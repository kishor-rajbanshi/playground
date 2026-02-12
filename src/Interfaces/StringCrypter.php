<?php

namespace KishorRajbanshi\Crypt\Interfaces;

interface StringCrypter
{
    /**
     * Encrypt a string without serialization.
     *
     * @param  string  $value
     * @return string
     *
     * @throws \KishorRajbanshi\Crypt\Exceptions\Encrypt
     */
    public function encryptString($value);

    /**
     * Decrypt the given string without unserialization.
     *
     * @param  string  $payload
     * @return string
     *
     * @throws \KishorRajbanshi\Crypt\Exceptions\Decrypt
     */
    public function decryptString($payload);
}
