<?php

namespace ArcdevPackages\Core\Helpers;

use Hashids\Hashids;

class HashHelper
{
    /**
     * Encode a numeric ID using Hashids.
     */
    public static function encodeId($id): string
    {
        return app(Hashids::class)->encode($id);
    }

    /**
     * Decode a hash back to a numeric ID.
     */
    public static function decodeId(string $hash): ?int
    {
        $decoded = app(Hashids::class)->decode($hash);
        return $decoded ? $decoded[0] : null;
    }
}
