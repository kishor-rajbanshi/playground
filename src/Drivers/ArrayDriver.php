<?php

namespace KishorRajbanshi\Sms\Drivers;

use KishorRajbanshi\Sms\Contracts\BulkSmsProvider;
use KishorRajbanshi\Sms\Contracts\SmsProvider;
use KishorRajbanshi\Sms\DTOs\Message;
use KishorRajbanshi\Sms\DTOs\Result;

class ArrayDriver implements BulkSmsProvider, SmsProvider
{
    /**
     * The array to store sent messages.
     *
     * @var array<int, array{to: string, content: string}>
     */
    protected array $messages = [];

    /**
     * Create a new instance of the array driver.
     *
     * @param  array<string, mixed>  $config  Optional configuration for the driver
     */
    public function __construct(protected array $config = []) {}

    /**
     * Send an SMS message.
     */
    public function send(Message $message): Result
    {
        $payload = [
            'to' => $message->to,
            'content' => $message->content,
        ];

        $this->messages[] = $payload;

        return Result::make(
            success: true,
            uid: uniqid(),
            provider: 'array',
            raw: $payload,
        );
    }

    /**
     * Send multiple SMS messages.
     *
     * @param  array<int, Message>  $messages
     * @return array<int, Result>
     */
    public function sendBulk(array $messages): array
    {
        return array_map(fn (Message $message) => $this->send($message), $messages);
    }

    /**
     * Get all sent messages.
     *
     * @return array<int, array{to: string, content: string}>
     */
    public function messages(): array
    {
        return $this->messages;
    }

    /**
     * Clear all stored messages.
     */
    public function flush(): void
    {
        $this->messages = [];
    }
}
