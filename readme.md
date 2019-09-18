## Install

    composer require phpmodules/encryption
    
## Usage

```php
<?php

use PHPModules\Encryption\Encrypter;

$encrypter = new Encrypter('secret key');
$data = $encrypter->encrypt('secret message');

$result = $encrypter->decrypt($data);
var_dump($result);
```