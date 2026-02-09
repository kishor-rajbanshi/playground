<?php

namespace KishorRajbanshi\Sms\Contracts;

use KishorRajbanshi\Sms\DTOs\Message;
use KishorRajbanshi\Sms\DTOs\Result;

interface BulkSmsProvider
{
    /**
     * Send multiple SMS messages.
     *
     * @param  array<int, Message>  $messages
     * @return array<int, Result>
     */
    public function sendBulk(array $messages): array;
}
