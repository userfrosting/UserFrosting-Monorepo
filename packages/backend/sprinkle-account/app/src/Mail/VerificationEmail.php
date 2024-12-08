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

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Repository\VerificationRepository;
use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;
use UserFrosting\Sprinkle\Core\Mail\Mailer;
use UserFrosting\Sprinkle\Core\Mail\TwigMailMessage;

class VerificationEmail
{
    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Config $config,
        protected VerificationRepository $verificationRepository,
        protected Twig $twig,
        protected Mailer $mailer,
    ) {
    }

    /**
     * Send verification email for specified user.
     *
     * @param UserInterface $user The user to send the email for
     */
    public function send(UserInterface $user, string $template = 'mail/verify-account.html.twig'): void
    {
        // Try to generate a new verification request
        $timeout = intval($this->config->get('verification.timeout'));
        $verification = $this->verificationRepository->create($user, $timeout);

        // Create and send verification email
        $message = new TwigMailMessage($this->twig, $template);

        // @phpstan-ignore-next-line Config limitation
        $message->from($this->config->get('address_book.admin'))
                ->addEmailRecipient(new EmailRecipient($user->email, $user->full_name))
                ->addParams([
                    'user'  => $user,
                    'token' => $verification->getToken(),
                ]);

        $this->mailer->send($message);
    }
}
