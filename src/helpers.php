<?php

use KishorRajbanshi\Sms\Sms;

if (! function_exists('sms')) {
    /**
     * Get the SMS instance.
     */
    function sms(): Sms
    {
        return app('sms');
    }
}
