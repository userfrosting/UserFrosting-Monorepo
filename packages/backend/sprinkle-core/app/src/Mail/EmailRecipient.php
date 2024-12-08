<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Mail;

/**
 * A class representing a recipient for a EmailRecipient.
 */
class EmailRecipient
{
    /**
     * @var string[][] A list of CCs for this recipient.  Each CC is an associative array with `email` and `name` properties.
     */
    protected array $cc = [];

    /**
     * @var string[][] A list of BCCs for this recipient.  Each BCC is an associative array with `email` and `name` properties.
     */
    protected array $bcc = [];

    /**
     * Create a new EmailRecipient instance.
     *
     * @param string  $email  The email address for this recipient.
     * @param string  $name   The name for this recipient.
     * @param mixed[] $params An array of template parameters (name => value) to render the email message with for this particular recipient.
     */
    public function __construct(
        protected string $email,
        protected string $name = '',
        protected array $params = []
    ) {
    }

    /**
     * Add a CC for this primary recipient.
     *
     * @param string $email The CC recipient email address.
     * @param string $name  The CC recipient name.
     */
    public function cc(string $email, string $name = ''): static
    {
        $this->cc[] = [
            'email' => $email,
            'name'  => $name,
        ];

        return $this;
    }

    /**
     * Add a BCC for this primary recipient.
     *
     * @param string $email The BCC recipient email address.
     * @param string $name  The BCC recipient name.
     */
    public function bcc(string $email, string $name = ''): static
    {
        $this->bcc[] = [
            'email' => $email,
            'name'  => $name,
        ];

        return $this;
    }

    /**
     * Get the primary recipient email address.
     *
     * @return string the primary recipient email address.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get the primary recipient name.
     *
     * @return string the primary recipient name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the parameters to use when rendering the template this recipient.
     *
     * @return mixed[] The parameters (name => value) to use when rendering an email template for this recipient.
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Get the list of CCs for this recipient.
     *
     * @return string[][] A list of CCs for this recipient.  Each CC is an associative array with `email` and `name` properties.
     */
    public function getCCs(): array
    {
        return $this->cc;
    }

    /**
     * Get the list of BCCs for this recipient.
     *
     * @return string[][] A list of BCCs for this recipient.  Each BCC is an associative array with `email` and `name` properties.
     */
    public function getBCCs(): array
    {
        return $this->bcc;
    }
}
