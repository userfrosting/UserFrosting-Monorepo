<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\User;

use Illuminate\Database\Connection;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Config\Config;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Event\UserCreatedEvent;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Account\Exceptions\LocaleNotFoundException;
use UserFrosting\Sprinkle\Account\Log\UserActivityLogger;
use UserFrosting\Sprinkle\Account\Validators\UserValidation;
use UserFrosting\Sprinkle\Admin\Mail\PasswordEmail;
use UserFrosting\Sprinkle\Core\Exceptions\Contracts\UserMessageException;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;
use UserFrosting\Sprinkle\Core\I18n\SiteLocaleInterface;
use UserFrosting\Sprinkle\Core\Log\DebugLogger;
use UserFrosting\Support\Message\UserMessage;

/**
 * Processes the request to create a new user (from the admin controls).
 *
 * Processes the request from the user creation form, checking that:
 * 1. The username and email are not already in use;
 * 2. The logged-in user has the necessary permissions to update the posted field(s);
 * 3. The submitted data is valid.
 * This route requires authentication.
 *
 * Request type: POST
 *
 * @throws ForbiddenException If user is not authorized to access page
 */
class UserCreateAction
{
    // Request schema for client side form validation
    protected string $schema = 'schema://requests/user/create.yaml';

    /**
     * Inject dependencies.
     *
     * @param \UserFrosting\Event\EventDispatcher $eventDispatcher
     */
    public function __construct(
        protected AlertStream $alert,
        protected Authenticator $authenticator,
        protected Config $config,
        protected Connection $db,
        protected EventDispatcherInterface $eventDispatcher,
        protected GroupInterface $groupModel,
        protected SiteLocaleInterface $siteLocale,
        protected Translator $translator,
        protected UserActivityLogger $userActivityLogger,
        protected PasswordEmail $passwordEmail,
        protected UserInterface $userModel,
        protected UserValidation $userValidation,
        protected DebugLogger $debugLogger,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param Request  $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->validateAccess();

        try {
            $this->handle($request);
        } catch (UserMessageException $e) {
            $title = $this->translateExceptionPart($e->getTitle());
            $description = $this->translateExceptionPart($e->getDescription());
            $this->alert->addMessage('danger', "$title: $description");

            throw $e;
        }

        $payload = json_encode([], JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle the request.
     *
     * @param Request $request
     */
    protected function handle(Request $request): void
    {
        // Get POST parameters.
        $params = (array) $request->getParsedBody();

        // Load the request schema
        $schema = $this->getSchema();

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);

        // If no password is set, set password as empty on initial creation.
        // We will then send email so new user can set it themselves via a
        // verification token.
        $data['password'] = $data['password'] ?? '';

        // Get current user. Won't be null, as AuthGuard prevent it
        /** @var UserInterface */
        $currentUser = $this->authenticator->user();

        // Validate request data
        $this->validateData($schema, $data);

        // Inject default locale if necessary.
        $data = $this->validateLocale($data);

        // Set flags
        $data['flag_verified'] = true;
        $data['flag_enabled'] = true;

        // Now that we check the form, we can try to register the actual user
        $user = new $this->userModel($data);

        // Try registration. Exceptions will be thrown if it fails.
        // No need to catch, as this kind of exception will automatically
        // handled by the error handlers.
        $this->userValidation->validate($user);

        // Determine if currentUser has permission to modify the group.  If so, show the 'group' dropdown.
        // Otherwise, set to the currentUser's group and disable the dropdown.
        if ($this->authenticator->checkAccess('create_user_field', ['fields' => ['group']]) === false) {
            // User which can't create group, can only create users in their own group.
            if (isset($data['group_id']) && $data['group_id'] !== $currentUser->group_id) {
                throw new ForbiddenException();
            }
        }

        // In any case, set the group id if not otherwise set
        if (!isset($data['group_id'])) {
            $data['group_id'] = $currentUser->group_id;
        }

        // Ready to save
        $this->db->transaction(function () use ($user, $data, $currentUser) {

            // Store new user to database
            $user->save();

            // Dispatch UserCreatedEvent
            $event = new UserCreatedEvent($user);
            $user = $this->eventDispatcher->dispatch($event)->user;

            // Create activity record
            $this->userActivityLogger->info("User {$currentUser->user_name} created a new account for {$user->user_name}.", [
                'type'    => 'account_create', // UserActivityLogger::TYPE_REGISTER,
                'user_id' => $user->id,
            ]);

            // If the password_mode is manual, do not send an email to set it. Else, send the email.
            if ($data['password'] === '') {
                $this->passwordEmail->send($user);
            }

            $this->alert->addMessageTranslated('success', 'USER.CREATED');
        });
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(): void
    {
        if (!$this->authenticator->checkAccess('create_user')) {
            throw new ForbiddenException();
        }
    }

    /**
     * Load the request schema.
     *
     * @return RequestSchemaInterface
     */
    protected function getSchema(): RequestSchemaInterface
    {
        $schema = new RequestSchema($this->schema);
        $schema->set('password.validators.length.min', $this->config->get('site.password.length.min'));
        $schema->set('password.validators.length.max', $this->config->get('site.password.length.max'));
        $schema->set('passwordc.validators.length.min', $this->config->get('site.password.length.min'));
        $schema->set('passwordc.validators.length.max', $this->config->get('site.password.length.max'));

        return $schema;
    }

    /**
     * Validate request POST data.
     *
     * @param RequestSchemaInterface $schema
     * @param mixed[]                $data
     */
    protected function validateData(RequestSchemaInterface $schema, array $data): void
    {
        $validator = new ServerSideValidator($schema, $this->translator);
        if ($validator->validate($data) === false && is_array($validator->errors())) {
            $e = new ValidationException();
            $e->addErrors($validator->errors());

            throw $e;
        }
    }

    /**
     * Ensure that in the case of using a single locale, that the locale is set.
     *
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    protected function validateLocale(array $data): array
    {
        $locales = $this->siteLocale->getAvailableIdentifiers();
        if (count($locales) <= 1) {
            $data['locale'] = $this->config->getString('site.registration.user_defaults.locale');
        }

        // Check that locale is valid. Required is done in schema.
        if (!in_array($data['locale'], $locales, true)) {
            $e = new LocaleNotFoundException();
            $e->setLocale($data['locale']);

            throw $e;
        }

        return $data;
    }

    /**
     * Translate a string or UserMessage to a string.
     *
     * @param string|UserMessage $message
     *
     * @return string
     */
    protected function translateExceptionPart(string|UserMessage $message): string
    {
        if ($message instanceof UserMessage) {
            return $this->translator->translate($message->message, $message->parameters);
        }

        return $this->translator->translate($message);
    }
}
