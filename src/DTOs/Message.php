<?php

namespace KishorRajbanshi\Sms\DTOs;

/**
 * Data transfer object for SMS message.
 */
class Message
{
    /**
     * Create a new Message instance.
     *
     * @param  string  $to  Recipient phone number
     * @param  string  $content  Message content
     */
    final public function __construct(public string $to, public string $content) {}

    /**
     * Create a new Message instance from given parameters.
     *
     * @param  string  $to  Recipient phone number
     * @param  string  $content  Message content
     */
    public static function make(string $to, string $content): static
    {
        return new static($to, $content);
    }
}
