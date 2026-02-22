<?php

namespace ArcdevPackages\Core\Helpers;

use Hashids\Hashids;

class HashHelper
{
    public static function encodeId($id): string
    {
        return app(Hashids::class)->encode($id);
    }

    public static function decodeId(string $hash): ?int
    {
        $decoded = app(Hashids::class)->decode($hash);
        return $decoded ? $decoded[0] : null;
    }
}