<?php

require __DIR__ . '/vendor/autoload.php';

use KishorRajbanshi\Crypt\Crypter;

$key = Crypter::generateKey('AES-128-CBC', 'base64');

$crypter = new Crypter($key, 'AES-128-CBC');

$data = $crypter->encrypt('Hello World');

echo "Encrypted: " . $data . PHP_EOL;

echo "Decrypted: " . $crypter->decrypt($data) . PHP_EOL;
