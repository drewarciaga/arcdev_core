<?php

return [
    'encrypt_code' => !empty(env('HASHIDS_SALT')) ? env('HASHIDS_SALT') : "Whiteranger99!",
    'secret_iv' => !empty(env('SECRET_IV')) ? env('SECRET_IV') : "ppsxZs0R93ssA!",

    /*
    |--------------------------------------------------------------------------
    | Full-Access Roles
    |--------------------------------------------------------------------------
    |
    | Roles that bypass EnsureUserHasRole entirely (full access to every
    | role-gated route). Defaults to "super_admin" only, preserving the
    | original hardcoded behavior. Consuming apps may opt additional roles
    | in via the CORE_FULL_ACCESS_ROLES env var (comma-separated), e.g.
    | CORE_FULL_ACCESS_ROLES=super_admin,owner — this affects ONLY the app
    | that sets it; all other apps keep the default.
    |
    */
    'full_access_roles' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('CORE_FULL_ACCESS_ROLES', 'super_admin'))
    ))),
];