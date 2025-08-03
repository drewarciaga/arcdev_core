<?php

namespace ArcdevPackages\Core\Helpers;

class Encrypt
{
    public static function encryptData($data): ?string
    {
        $secretKey = config('core.encrypt_code');
        $secretIv = config('core.secret_iv');
        $cipher = 'aes-256-cbc';

        $key = substr(hash('sha256', $secretKey), 0, 32);
        $iv = substr(hash('sha256', $secretIv), 0, 16);

        return openssl_encrypt($data, $cipher, $key, 0, $iv);
    }
}
