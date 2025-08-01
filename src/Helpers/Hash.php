<?php

namespace ArcdevPackages\Core\Helpers;

use Hashids\Hashids;

function encodeId($id)
{
    return app(Hashids::class)->encode($id);
}

function decodeId($hash)
{
    $decoded = app(Hashids::class)->decode($hash);
    return $decoded ? $decoded[0] : null;
}