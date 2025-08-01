<?php

namespace ArcdevPackages\Core\Helpers;

function encryptData($data)
{
    $secretKey = config('core.encrypt_code');
    $secretIv = config('core.secret_iv');
    $cipher = 'aes-256-cbc';
    // Hash the secret key and IV
    $key = substr(hash('sha256', $secretKey), 0, 32);
    $iv = substr(hash('sha256', $secretIv), 0, 16);

    // Encrypt the data
    $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);

    // Encode the result in base64
    return $encrypted;
}