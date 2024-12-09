<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Mail;

use Carbon\Carbon;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Repository\PasswordResetRepository;
use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;
use UserFrosting\Sprinkle\Core\Mail\Mailer;
use UserFrosting\Sprinkle\Core\Mail\TwigMailMessage;

class PasswordResetEmail
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
    public function send(UserInterface $user, string $template = 'mail/password-reset.html.twig'): void
    {
        // Try to generate a new verification request
        $timeout = $this->config->getInt('password_reset.timeouts.reset', 10800);
        $passwordReset = $this->repoPasswordReset->create($user, $timeout);

        // Create and send verification email
        $message = new TwigMailMessage($this->twig, $template);

        // @phpstan-ignore-next-line Config limitation
        $message->from($this->config->get('address_book.admin'))
                ->addEmailRecipient(new EmailRecipient($user->email, $user->full_name))
                ->addParams([
                    'user'         => $user,
                    'token'        => $passwordReset->getToken(),
                    'request_date' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

        $this->mailer->send($message);
    }
}
