<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Bakery;

use Carbon\Carbon;
use DI\Attribute\Inject;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;
use UserFrosting\Sprinkle\Core\Mail\Mailer;
use UserFrosting\Sprinkle\Core\Mail\StaticMailMessage;

/**
 * Command to test email setup.
 */
final class TestMailCommand extends Command
{
    use WithSymfonyStyle;

    #[Inject]
    protected Config $config;

    #[Inject]
    protected Mailer $mailer;

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('test:mail')
             ->setDescription('Test mail settings')
             ->setHelp('This command let you test the email sending capability of your UserFrosting setup.')
             ->addOption('to', null, InputOption::VALUE_REQUIRED, 'Email address to send test email to. Use admin contact if omitted.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Testing Email Configuration');

        // Get options
        if (is_string($input->getOption('to'))) {
            $to = $input->getOption('to');
        } else {
            $to = $this->config->getString('address_book.admin.email', '');
        }

        $this->io->writeln("Sending test email to : $to");

        // Create and send email
        $title = $this->config->getString('site.title') . ' - Test email';
        $body = sprintf('A test email has been submitted from %s on %s.', $this->config->getString('site.title'), Carbon::now()->format('Y-m-d H:i:s'));
        $message = new StaticMailMessage($title, $body);
        $message->from($this->config->getArray('address_book.admin', []))
                ->addEmailRecipient(new EmailRecipient($to, $to));

        try {
            $this->mailer->send($message);
        } catch (PHPMailerException $e) {
            $this->io->error($e->getMessage());

            return self::FAILURE;
        }

        $this->io->success("Test email sent to $to !");

        return self::SUCCESS;
    }
}
