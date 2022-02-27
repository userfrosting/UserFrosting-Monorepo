<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Controller;

use Illuminate\Database\Connection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Event\EventDispatcher;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\I18n\Translator;
use UserFrosting\Session\Session;
use UserFrosting\Sprinkle\Account\Account\Registration;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Event\User\UserCreatedEvent;
use UserFrosting\Sprinkle\Account\Exceptions\RegistrationException;
use UserFrosting\Sprinkle\Account\Log\UserActivityLogger;
use UserFrosting\Sprinkle\Account\Repository\VerificationRepository;
use UserFrosting\Sprinkle\Account\Validators\UserValidation;
use UserFrosting\Sprinkle\Core\I18n\SiteLocale;
use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;
use UserFrosting\Sprinkle\Core\Mail\Mailer;
use UserFrosting\Sprinkle\Core\Mail\TwigMailMessage;
use UserFrosting\Sprinkle\Core\Throttle\Throttler;
use UserFrosting\Sprinkle\Core\Throttle\ThrottlerDelayException;
use UserFrosting\Sprinkle\Core\Util\Captcha;
use UserFrosting\Support\Repository\Repository as Config;

/**
 * Processes an new account registration request.
 *
 * This is throttled to prevent account enumeration, since it needs to divulge when a username/email has been used.
 * Processes the request from the form on the registration page, checking that:
 * 1. The honeypot was not modified;
 * 2. The master account has already been created (during installation);
 * 3. Account registration is enabled;
 * 4. The user is not already logged in;
 * 5. Valid information was entered;
 * 6. The captcha, if enabled, is correct;
 * 7. The username and email are not already taken.
 * Automatically sends an activation link upon success, if account activation is enabled.
 * This route is "public access".
 * Returns the User Object for the user record that was created.
 *
 * AuthGuard: false
 * GuestGuard: true
 * Route: /account/register
 * Route Name: account.register
 * Request type: POST
 */
class RegisterAction
{
    // Request schema to use to validate data.
    protected string $schema = 'schema://requests/register.yaml';

    /**
     * Inject dependencies.
     *
     * @param Config         $config
     * @param UserInterface  $userModel
     * @param SiteLocale     $locale
     * @param Translator     $translator
     * @param Session        $session
     * @param UserValidation $userValidation
     * @param AlertStream    $alert
     */
    public function __construct(
        protected Config $config,
        protected UserInterface $userModel,
        protected SiteLocale $locale,
        protected Translator $translator,
        protected Session $session,
        protected UserValidation $userValidation,
        protected AlertStream $alert,
        protected Connection $db,
        protected Throttler $throttler,
        protected EventDispatcher $eventDispatcher,
        protected VerificationRepository $verificationRepository,
        protected Twig $twig,
        protected Mailer $mailer,
        protected UserActivityLogger $userActivityLogger,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param Request  $request
     * @param Response $response
     *
     * @throws RegistrationException
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $payload = $this->handle($request);
        $payload = json_encode($payload ?? [], JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle the request and return the payload.
     *
     * @param Request $request
     *
     * @return mixed[]|null
     */
    protected function handle(Request $request): ?array
    {
        // Throttle requests.
        $this->throttle();

        // Get POST parameters
        $params = (array) $request->getParsedBody();

        // Validate each elements
        $this->validateRegistrationIsEnabled();
        $this->validateHoneypot($params);
        $this->validateMasterUser();

        // Load the request schema
        $schema = $this->getSchema();

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);

        // Inject default locale if necessary.
        $data = $this->validateLocale($data);

        // Validate request data
        $this->validateData($schema, $data);

        // Check captcha
        $this->checkCaptcha($data);

        // Set flags
        $data['flag_verified'] = !$this->requireEmailVerification();
        $data['flag_enabled'] = true;

        // Now that we check the form, we can try to register the actual user
        $user = new $this->userModel($data);

        // Try registration. Exceptions will be thrown if it fails.
        // No need to catch, as this kind of exception will automatically
        // handled by the error handlers.
        $this->userValidation->validate($user);

        // Ready to save
        /** @var UserInterface */
        $user = $this->db->transaction(function () use ($user) {

            // Log throttle-able event
            $this->throttler->logEvent('registration_attempt');

            // Store new user to database
            $user->save();

            // Dispatch UserCreatedEvent
            $event = new UserCreatedEvent($user);
            $user = $this->eventDispatcher->dispatch($event)->user;

            // Create activity record
            $this->userActivityLogger->info("User {$user->user_name} registered for a new account.", [
                'type'    => 'sign_up',
                'user_id' => $user->id,
            ]);

            // Send activation email
            $this->sendVerificationEmail($user);

            return $user;
        });

        $this->addMessage($user);

        return $user->toArray();
    }

    /**
     * Check the honeypot. 'spiderbro' is not a real field, it is hidden on
     * the main page and must be submitted with its default value for this
     * to be processed.
     *
     * @param mixed[] $params
     *
     * @throws RegistrationException If honeypot challenge fails.
     */
    protected function validateHoneypot(array $params): void
    {
        if (!isset($params['spiderbro']) || $params['spiderbro'] != 'http://') {
            throw new RegistrationException('Possible spam detected: Honey pot challenge failed.');
        }
    }

    /**
     * Security measure: do not allow registering new users until the master
     * account has been created.
     *
     * @throws RegistrationException If master user is not created.
     */
    protected function validateMasterUser(): void
    {
        $masterId = intval($this->config->get('reserved_user_ids.master'));
        if ($this->userModel::find($masterId) === null) {
            $e = new RegistrationException('Master account not created.');
            $e->setDescription('ACCOUNT.MASTER_NOT_EXISTS');

            throw $e;
        }
    }

    /**
     * Check if registration is currently enabled.
     *
     * @throws RegistrationException If registration if disabled
     */
    protected function validateRegistrationIsEnabled(): void
    {
        if ($this->config->get('site.registration.enabled') === false) {
            $e = new RegistrationException('Registration is disable');
            $e->setDescription('REGISTRATION.DISABLED');

            throw $e;
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
     * Ensure that in the case of using a single locale, that the locale is set.
     *
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    protected function validateLocale(array $data): array
    {
        if (count($this->locale->getAvailableIdentifiers()) <= 1) {
            $data['locale'] = $this->config->get('site.registration.user_defaults.locale');
        }

        return $data;
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
        if ($validator->validate($data) === false) {
            // TODO
            // $e = new RegistrationException('Registration is disable');
            // $e->setDescription('REGISTRATION.DISABLED');

            // throw $e;
            // $ms->addValidationErrors($validator); TODO Need a validation exception that replicate `addValidationErrors`
            // 400 error ?
        }
    }

    /**
     * Check captcha, if required by config.
     *
     * @param string[] $data
     *
     * @throws RegistrationException If captcha fails.
     */
    protected function checkCaptcha(array $data): void
    {
        if ($this->config->get('site.registration.captcha') === true) {
            $key = strval($this->config->get('session.keys.captcha'));
            $captcha = new Captcha($this->session, $key);
            if (!isset($data['captcha']) || !$captcha->verifyCode($data['captcha'])) {
                $e = new RegistrationException('Failed Captcha');
                $e->setDescription('CAPTCHA.FAIL'); // 400 error ?

                throw $e;
            }
        }
    }

    /**
     * Add success message to the alert stream.
     *
     * @param UserInterface $user
     */
    protected function addMessage(UserInterface $user): void
    {
        // Verification required
        if ($this->requireEmailVerification() === true) {
            $this->alert->addMessageTranslated('success', 'REGISTRATION.COMPLETE_TYPE2', $user->toArray());
        }

        // No verification required
        $this->alert->addMessageTranslated('success', 'REGISTRATION.COMPLETE_TYPE1');
    }

    /**
     * Is email verification is required.
     *
     * @return bool
     */
    protected function requireEmailVerification(): bool
    {
        return boolval($this->config->get('site.registration.require_email_verification'));
    }

    /**
     * Throttle requests.
     */
    protected function throttle(): void
    {
        $delay = $this->throttler->getDelay('registration_attempt');
        if ($delay > 0) {
            $e = new ThrottlerDelayException();
            $e->setDelay($delay);

            throw $e;
        }
    }

    /**
     * Send verification email for specified user.
     *
     * @param UserInterface $user The user to send the email for
     */
    // TODO : This could probably be separated in a different class to cut on dependencies.
    protected function sendVerificationEmail(UserInterface $user): void
    {
        if ($this->requireEmailVerification() === false) {
            return;
        }

        // Try to generate a new verification request
        $timeout = intval($this->config->get('verification.timeout'));
        $verification = $this->verificationRepository->create($user, $timeout);

        // Create and send verification email
        $message = new TwigMailMessage($this->twig, 'mail/verify-account.html.twig');

        $message->from($this->config->get('address_book.admin'))
                ->addEmailRecipient(new EmailRecipient($user->email, $user->full_name))
                ->addParams([
                    'user'  => $user,
                    'token' => $verification->getToken(),
                ]);

        $this->mailer->send($message);
    }
}
