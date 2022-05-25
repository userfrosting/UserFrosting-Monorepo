<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\Helpers;

use UserFrosting\Support\Message\UserMessage;

/**
 * Translator is required in the controller to translate exception messages.
 */
trait TranslateExceptionPart
{
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
