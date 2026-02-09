<?php

namespace KishorRajbanshi\Sms;

use InvalidArgumentException;
use KishorRajbanshi\Sms\DTOs\Message;
use KishorRajbanshi\Sms\DTOs\Result;

class Sms
{
    /**
     * The name of the driver to use for sending SMS.
     */
    protected ?string $driver = null;

    /*
     * The recipient phone number for the SMS.
     */
    protected ?string $to = null;

    /*
     * The message content for the SMS.
     */
    protected ?string $content = null;

    /**
     * Create a new Sms instance.
     */
    public function __construct(protected SmsManager $manager) {}

    /**
     * Set the driver to use for sending SMS.
     */
    public function driver(string $name): static
    {
        $clone = clone $this;
        $clone->driver = $name;

        return $clone;
    }

    /**
     * Set the recipient phone number for the SMS.
     */
    public function to(string $to): static
    {
        $clone = clone $this;
        $clone->to = $to;

        return $clone;
    }

    /**
     * Set the message content for the SMS.
     */
    public function content(string $content): static
    {
        $clone = clone $this;
        $clone->content = $content;

        return $clone;
    }

    /**
     * Send an SMS message.
     *
     * @param  string|Message|null  $to  Optional recipient phone number or Message object
     * @param  string|null  $content  Optional message content
     *
     * @throws InvalidArgumentException
     */
    public function send(string|Message|null $to = null, ?string $content = null): Result
    {
        $message = $to instanceof Message
            ? $to
            : new Message(
                $to ?? $this->to ?? throw new InvalidArgumentException(
                    'Recipient phone number is required.'
                ),
                $content ?? $this->content ?? throw new InvalidArgumentException(
                    'Message content is required.'
                )
            );

        return $this->manager->driver($this->driver)->send($message);
    }

    /**
     * Send multiple SMS messages.
     *
     * @param  array<int, Message|array{to: string, content: string}>  $messages
     * @return array<int, Result>
     */
    public function sendBulk(array $messages): array
    {
        $messages = array_map(function ($message) {
            return $message instanceof Message
                ? $message
                : new Message(
                    $message['to'],
                    $message['content']
                );
        }, $messages);

        return $this->manager->driver($this->driver)->sendBulk($messages);
    }
}
