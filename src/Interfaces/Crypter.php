<?php

namespace KishorRajbanshi\Crypt\Interfaces;

interface Crypter
{
    /**
     * Encrypt the given value.
     *
     * @param  mixed  $value
     * @param  bool  $serialize
     * @return string
     *
     * @throws \KishorRajbanshi\Crypt\Exceptions\Encrypt
     */
    public function encrypt($value, $serialize = true);

    /**
     * Decrypt the given value.
     *
     * @param  string  $payload
     * @param  bool  $unserialize
     * @return mixed
     *
     * @throws \KishorRajbanshi\Crypt\Exceptions\Decrypt
     */
    public function decrypt($payload, $unserialize = true);
}
