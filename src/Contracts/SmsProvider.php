<?php

namespace KishorRajbanshi\Sms\Contracts;

use KishorRajbanshi\Sms\DTOs\Message;
use KishorRajbanshi\Sms\DTOs\Result;

interface SmsProvider
{
    /**
     * Send an SMS message.
     */
    public function send(Message $message): Result;
}
