<?php

namespace KishorRajbanshi\Sms\Facades;

use Illuminate\Support\Facades\Facade;
use KishorRajbanshi\Sms\DTOs\Message;
use KishorRajbanshi\Sms\DTOs\Result;
use KishorRajbanshi\Sms\Sms as SmsService;

/**
 * @method static SmsService driver(string $name)
 * @method static SmsService to(string $to)
 * @method static SmsService content(string $content)
 * @method static Result send(string|Message|null $to = null, ?string $content = null)
 * @method static array<int, Result> sendBulk(array<int, Message|array{to: string, content: string}> $messages)
 *
 * @see SmsService
 */
class Sms extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'sms';
    }
}
