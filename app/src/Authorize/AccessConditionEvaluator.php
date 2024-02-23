<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Authorize;

use Monolog\Logger;
use PhpParser\Error as PhpParserException;
use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard as StandardPrettyPrinter;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Log\AuthLogger;

/**
 * This class parses access control condition expressions.
 */
class AccessConditionEvaluator extends NodeVisitorAbstract
{
    /**
     * @var Parser The Parser object to use (initialized in the ctor)
     */
    protected Parser $parser;

    /**
     * @var bool Should we log debug messages?
     */
    protected bool $debug = false;

    /**
     * @var StandardPrettyPrinter
     */
    protected StandardPrettyPrinter $prettyPrinter;

    /**
     * @var NodeTraverser
     */
    protected NodeTraverser $traverser;

    /**
     * Create a new ParserNodeFunctionEvaluator object.
     *
     * @param AccessConditionsInterface $accessConditions The parameters to be used when evaluating the methods in the condition expression, as an array.
     * @param AuthLogger                $logger           A Monolog logger, used to dump debugging info for authorization evaluations.
     * @param Config                    $config           Set to true if you want debugging information printed to the auth log.
     * @param mixed[]                   $params
     * @param StandardPrettyPrinter     $prettyPrinter
     * @param NodeTraverser             $traverser
     */
    public function __construct(
        protected AccessConditionsInterface $accessConditions,
        protected AuthLogger $logger,
        Config $config,
        protected array $params = [],
        ?StandardPrettyPrinter $prettyPrinter = null,
        ?NodeTraverser $traverser = null,
    ) {
        $this->debug = $config->getBool('debug.auth');
        $this->parser = (new ParserFactory())->create(ParserFactory::ONLY_PHP7);
        $this->prettyPrinter = $prettyPrinter ?? new StandardPrettyPrinter();
        $this->traverser = $traverser ?? new NodeTraverser();
        $this->traverser->addVisitor($this);
    }

    /**
     * {@inheritDoc}
     */
    public function leaveNode(Node $node)
    {
        // Look for function calls
        if (!$node instanceof \PhpParser\Node\Expr\FuncCall) {
            // @phpstan-ignore-next-line Style guide doesn't allow to return null;
            return;
        }

        // Get the method name
        // @phpstan-ignore-next-line False positive. The name is always a \PhpParser\Node\Name.
        $callbackName = $node->name->toString();

        // Get the method arguments
        /** @var \PhpParser\Node\Arg[] */
        $argNodes = $node->args;

        $args = [];
        $argsInfo = [];
        foreach ($argNodes as $arg) {
            $argString = $this->prettyPrinter->prettyPrintExpr($arg->value);

            // Debugger info
            $currentArgInfo = [
                'expression' => $argString,
            ];
            // Resolve parameter placeholders ('variable' names (either single-word or array-dot identifiers))
            if ($arg->value instanceof \PhpParser\Node\Expr\BinaryOp\Concat || $arg->value instanceof \PhpParser\Node\Expr\ConstFetch) {
                $value = $this->resolveParamPath($argString);
                $currentArgInfo['type'] = 'parameter';
                $currentArgInfo['resolved_value'] = $value;
            // Resolve arrays
            } elseif ($arg->value instanceof \PhpParser\Node\Expr\Array_) {
                $value = $this->resolveArray($arg->value);
                $currentArgInfo['type'] = 'array';
                $currentArgInfo['resolved_value'] = print_r($value, true);
            // Resolve strings
            } elseif ($arg->value instanceof \PhpParser\Node\Scalar\String_) {
                $value = $arg->value->value;
                $currentArgInfo['type'] = 'string';
                $currentArgInfo['resolved_value'] = $value;
            // Resolve numbers
            } elseif ($arg->value instanceof \PhpParser\Node\Scalar\DNumber) {
                $value = $arg->value->value;
                $currentArgInfo['type'] = 'float';
                $currentArgInfo['resolved_value'] = $value;
            } elseif ($arg->value instanceof \PhpParser\Node\Scalar\LNumber) {
                $value = $arg->value->value;
                $currentArgInfo['type'] = 'integer';
                $currentArgInfo['resolved_value'] = $value;
            // Anything else is simply interpreted as its literal string value
            } else {
                $value = $argString;
                $currentArgInfo['type'] = 'unknown';
                $currentArgInfo['resolved_value'] = $value;
            }

            $args[] = $value;
            $argsInfo[] = $currentArgInfo;
        }

        if ($this->debug) {
            if (count($args) !== 0) {
                $this->logger->debug("Evaluating callback '$callbackName' on: ", $argsInfo);
            } else {
                $this->logger->debug("Evaluating callback '$callbackName'...");
            }
        }

        // Call the specified access condition callback with the specified arguments.
        // @phpstan-ignore-next-line Phpstan doesn't understand array is callable.
        if (isset($this->accessConditions[$callbackName]) && is_callable($this->accessConditions[$callbackName])) {
            $result = call_user_func_array($this->accessConditions[$callbackName], $args);
        } else {
            throw new AuthorizationException("Authorization failed: Access condition method '$callbackName' does not exist.");
        }

        if ($this->debug) {
            $this->logger->debug('Result: ' . ($result == true ? '1' : '0'));
        }

        return new \PhpParser\Node\Scalar\LNumber($result == true ? 1 : 0);
    }

    /**
     * Set params.
     *
     * @param mixed[] $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * Resolve an array expression in a condition expression into an actual array.
     *
     * @param Array_ $value the array, represented as a string.
     *
     * @return mixed[] the array, as a plain ol' PHP array.
     */
    private function resolveArray(Array_ $value)
    {
        $arr = [];

        /** @var \PhpParser\Node\Expr\ArrayItem $item */
        foreach ($value->items as $item) {
            if ($item->key == true) {
                // @phpstan-ignore-next-line : $item define key/value as abstract method Expr, actual object usually has value property.
                $arr[$item->key->value] = $item->value->value;
            } else {
                // @phpstan-ignore-next-line : $item define value as abstract method Expr, actual object usually has value property.
                $arr[] = $item->value->value;
            }
        }

        return $arr;
    }

    /**
     * Resolve a parameter path (e.g. "user.id", "post", etc) into its value.
     *
     * @param string $path the name of the parameter to resolve, based on the parameters set in this object.
     *
     * @throws AuthorizationException the path could not be resolved.  Path is malformed or key does not exist.
     *
     * @return mixed the value of the specified parameter.
     */
    private function resolveParamPath($path)
    {
        $pathTokens = explode('.', $path);
        $value = $this->params;
        foreach ($pathTokens as $token) {
            $token = trim($token);
            if (is_array($value) && isset($value[$token])) {
                $value = $value[$token];
                continue;
            // @phpstan-ignore-next-line Allow variable property for this use
            } elseif (is_object($value) && isset($value->$token)) {
                // @phpstan-ignore-next-line Allow variable property for this use
                $value = $value->$token;
                continue;
            } else {
                throw new AuthorizationException("Cannot resolve the path \"$path\". Error at token \"$token\".");
            }
        }

        return $value;
    }

    /**
     * Evaluates a condition expression, based on the given parameters.
     *
     * The special parameter `self` is an array of the current user's data.
     * This get included automatically, and so does not need to be passed in.
     *
     * @param string             $condition a boolean expression composed of calls to AccessCondition functions.
     * @param mixed[]            $params    the parameters to be used when evaluating the expression.
     * @param UserInterface|null $user      the user to be used when evaluating the expression.
     *
     * @return bool true if the condition is passed for the given parameters, otherwise returns false.
     */
    public function evaluate(string $condition, array $params = [], ?UserInterface $user = null): bool
    {
        // Set the reserved `self` parameters.
        // This replaces any values of `self` specified in the arguments, thus preventing them from being overridden in malicious user input.
        // (For example, from an unfiltered request body).
        if ($user !== null) {
            $params['self'] = $user->toArray();
        }

        $this->setParams($params);

        $code = "<?php $condition;";

        if ($this->debug) {
            $this->logger->debug("Evaluating access condition '$condition' with parameters:", $params);
        }

        // Traverse the parse tree, and execute any callbacks found using the supplied parameters.
        // Replace the function node with the return value of the callback.
        try {
            // parse
            /** @var \PhpParser\Node\Stmt[] */
            $stmts = $this->parser->parse($code);

            // traverse
            $stmts = $this->traverser->traverse($stmts);

            // Evaluate boolean statement. It is safe to use eval() here, because
            // our expression has been reduced entirely to a boolean expression.
            // @phpstan-ignore-next-line $stmts[0] is always a \PhpParser\Node\Stmt\Expression
            $expr = $this->prettyPrinter->prettyPrintExpr($stmts[0]->expr);
            $expr_eval = 'return ' . $expr . ";\n";
            $result = eval($expr_eval);

            if ($this->debug) {
                $this->logger->debug("Expression '$expr' evaluates to " . ($result == true ? 'true' : 'false'));
            }

            // Return loose bool, as strict bool.
            return ($result == true) ? true : false;
        } catch (PhpParserException|AuthorizationException $e) {
            if ($this->debug) {
                $this->logger->debug("Error parsing access condition '$condition': " . $e->getMessage());
            }

            return false;
        }
    }
}
