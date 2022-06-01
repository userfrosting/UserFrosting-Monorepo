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

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Account\Mail\PasswordResetEmail;
use UserFrosting\Sprinkle\Admin\Controller\UserHelper;

/**
 * Processes the request to send a user a password reset email.
 *
 * Processes the request from the user update form, checking that:
 * 1. The target user's new email address, if specified, is not already in use;
 * 2. The logged-in user has the necessary permissions to update the posted field(s);
 * 3. We're not trying to disable the master account;
 * 4. The submitted data is valid.
 * This route requires authentication.
 *
 * Request type: POST
 */
class UserPasswordAction
{
    /**
     * Inject dependencies.
     */
    public function __construct(
        protected AlertStream $alert,
        protected Authenticator $authenticator,
        protected PasswordResetEmail $passwordEmail,
        protected UserHelper $userHelper,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param string   $user_name The name of the user to delete, from the URI.
     * @param Request  $request
     * @param Response $response
     */
    public function __invoke(string $user_name, Request $request, Response $response): Response
    {
        $this->handle($user_name);
        $payload = json_encode([], JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle the request.
     *
     * @param string $user_name
     */
    protected function handle(string $user_name): void
    {
        // Get user to delete.
        $user = $this->userHelper->getUser(['user_name' => $user_name]);

        // Access-controlled page based on the user.
        $this->validateAccess($user);

        // Send password reset email.
        // TODO : Mail template
        $this->passwordEmail->send($user, 'mail/password-reset.html.twig');

        $this->alert->addMessageTranslated('success', 'PASSWORD.FORGET.REQUEST_SENT', [
            'email' => $user->email,
        ]);
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(UserInterface $user): void
    {
        if (!$this->authenticator->checkAccess('update_user_field', [
            'user'   => $user,
            'fields' => ['password'],
        ])) {
            throw new ForbiddenException();
        }
    }
}
