<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\ServicesProvider;

use UserFrosting\Config\Config;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Core\Log\MailLoggerInterface;
use UserFrosting\Sprinkle\Core\Mail\Mailer;

/*
 * Mail service.
 */
class MailService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            Mailer::class => function (Config $config, MailLoggerInterface $logger) {
                $mailer = new Mailer($logger, $config->get('mail'));

                return $mailer;
            },
        ];
    }
}
