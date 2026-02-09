<?php

namespace KishorRajbanshi\Sms;

use Illuminate\Support\Manager;
use KishorRajbanshi\Sms\Drivers\ArrayDriver;
use KishorRajbanshi\Sms\Drivers\LogDriver;

class SmsManager extends Manager
{
    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): ?string
    {
        return $this->config->get('sms.default');
    }

    /**
     * Create an instance of the log driver.
     */
    protected function createLogDriver(): LogDriver
    {
        return new LogDriver(
            $this->config->get('sms.drivers.log')
        );
    }

    /**
     * Create an instance of the array driver.
     */
    protected function createArrayDriver(): ArrayDriver
    {
        return new ArrayDriver(
            $this->config->get('sms.drivers.array')
        );
    }
}
