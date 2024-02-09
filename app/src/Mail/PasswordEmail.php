<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Mail;

use Carbon\Carbon;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Repository\PasswordResetRepository;
use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;
use UserFrosting\Sprinkle\Core\Mail\Mailer;
use UserFrosting\Sprinkle\Core\Mail\TwigMailMessage;

class PasswordEmail
{
    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Config $config,
        protected PasswordResetRepository $repoPasswordReset,
        protected Twig $twig,
        protected Mailer $mailer,
    ) {
    }

    /**
     * Send verification email for specified user.
     *
     * @param UserInterface $user The user to send the email for
     */
    public function send(UserInterface $user, string $template = 'mail/password-create.html.twig'): void
    {
        // Try to generate a new verification request
        $timeout = $this->config->getInt('password_reset.timeouts.create', 86400);
        $verification = $this->repoPasswordReset->create($user, $timeout);

        // Create and send verification email
        $message = new TwigMailMessage($this->twig, $template);

        // @phpstan-ignore-next-line Config limitation
        $message->from($this->config->get('address_book.admin'))
                ->addEmailRecipient(new EmailRecipient($user->email, $user->full_name))
                ->addParams([
                    'user'                       => $user,
                    'create_password_expiration' => $timeout / 3600 . ' hours',
                    'token'                      => $verification->getToken(),
                    'request_date'               => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

        $this->mailer->send($message);
    }
}
