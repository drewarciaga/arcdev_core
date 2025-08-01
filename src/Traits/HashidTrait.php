<?php

namespace ArcdevPackages\Core\Traits;

use Hashids\Hashids;

trait HashidTrait
{
    protected static function bootHashidTrait()
    {
        // Automatically encode ID when the model is retrieved
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
        return app(Hashids::class)->encode($id);
    }

    public static function decodeId($hashid)
    {
        $decoded = app(Hashids::class)->decode($hashid);
        return $decoded ? $decoded[0] : null;
    }
}