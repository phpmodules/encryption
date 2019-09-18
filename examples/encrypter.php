<?php

use PHPModules\Encryption\Encrypter;

require __DIR__ . '/../vendor/autoload.php';

$encrypter = new Encrypter('secret key');
$data = $encrypter->encrypt('secret message');

$result = $encrypter->decrypt($data);
var_dump($result);
