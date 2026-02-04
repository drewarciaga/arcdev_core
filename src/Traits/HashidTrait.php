<?php

namespace ArcdevPackages\Core\Traits;

use Hashids\Hashids;

trait HashidTrait
{
    protected static ?Hashids $hashids = null;

    protected static function hashids(): Hashids
    {
        if (! static::$hashids) {
            static::$hashids = new Hashids(config('app.key'), 6);
        }

        return static::$hashids;
    }

    protected static function bootHashidTrait()
    {
        static::retrieved(function ($model) {
            $model->hashid = self::encodeId($model->id);
        });
    }

    public function getHashidAttribute()
    {
        return self::encodeId($this->id);
    }

    protected static function encodeId($id)
    {
        return static::hashids()->encode($id);
    }

    public static function decodeId($hashid)
    {
        $decoded = static::hashids()->decode($hashid);
        return $decoded ? $decoded[0] : null;
    }
}
