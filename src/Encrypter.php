<?php


namespace PHPModules\Encryption;


class Encrypter
{
    /**
     * @var string|string
     */
    private $key;

    /**
     * @var string
     */
    private $cipher;

    /**
     * Encrypter constructor.
     * @param string $key
     * @param string $cipher
     * @throws EncryptException
     */
    public function __construct(string $key, $cipher = 'AES-128-CBC')
    {
        $this->key = $key;
        if (!$this->supported($cipher)) {
            throw new EncryptException('the cipher is not supported.');
        }
        $this->cipher = $cipher;
    }

    /**
     * @param string $cipher
     * @return bool
     */
    private function supported(string $cipher)
    {
        return in_array($cipher, openssl_get_cipher_methods());
    }

    /**
     * @param $value
     * @return string
     * @throws EncryptException
     */
    public function encrypt($value)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $value = openssl_encrypt($value, $this->cipher, $this->key, 0, $iv);
        if ($value === false) {
            throw new EncryptException('Could not encrypt the data.');
        }
        return base64_encode(base64_encode($iv).'$'.$value);
    }

    /**
     * @param $data
     * @return string
     */
    public function decrypt($data)
    {
        list($iv, $value) = explode('$',base64_decode($data));
        $iv = base64_decode($iv);

        return openssl_decrypt($value, $this->cipher, $this->key, 0, $iv);
    }

}