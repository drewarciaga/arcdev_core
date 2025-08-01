<?php

return [
    'encrypt_code' => !empty(env('HASHIDS_SALT')) ? env('HASHIDS_SALT') : "Whiteranger99!",
    'secret_iv' => !empty(env('SECRET_IV')) ? env('SECRET_IV') : "ppsxZs0R93ssA!",
];