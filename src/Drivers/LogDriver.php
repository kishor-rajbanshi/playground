<?php

namespace KishorRajbanshi\Sms\Drivers;

use Illuminate\Support\Facades\Log;
use KishorRajbanshi\Sms\Contracts\BulkSmsProvider;
use KishorRajbanshi\Sms\Contracts\SmsProvider;
use KishorRajbanshi\Sms\DTOs\Message;
use KishorRajbanshi\Sms\DTOs\Result;

class LogDriver implements BulkSmsProvider, SmsProvider
{
    /**
     * Create a new instance of the log driver.
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

        Log::info('SMS Sent (log driver)', $payload);

        return Result::make(
            success: true,
            uid: uniqid(),
            provider: 'log',
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
}
