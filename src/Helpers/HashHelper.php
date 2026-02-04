<?php

namespace ArcdevPackages\Core\Helpers;

use Hashids\Hashids;

class HashHelper
{
    protected static ?Hashids $hashids = null;

    protected static function hashids(): Hashids
    {
        if (! static::$hashids) {
            static::$hashids = new Hashids(config('app.key'), 6);
        }

        return static::$hashids;
    }

    public static function encodeId($id): string
    {
        return static::hashids()->encode($id);
    }

    public static function decodeId(string $hash): ?int
    {
        $decoded = static::hashids()->decode($hash);
        return $decoded ? $decoded[0] : null;
    }
}
