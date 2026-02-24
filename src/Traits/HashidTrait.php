<?php

namespace ArcdevPackages\Core\Traits;

trait HashidTrait
{
    protected static array $hashidColumnCache = [];

    protected static function bootHashidTrait()
    {
        static::retrieved(function ($model) {
            $hash = $model->computeHashid();
            $model->setAttribute('hashid', $hash);

            if ($model->hasHashidColumn()) {
                $model->syncOriginalAttribute('hashid');
            }
        });

        static::created(function ($model) {
            if (!$model->hasHashidColumn()) return;

            $existing = $model->getAttribute('hashid');
            if (!empty($existing)) return;

            $model->forceFill([
                'hashid' => $model->computeHashid(),
            ])->saveQuietly();
        });
    }

    public function getHashidAttribute($value)
    {
        if (!empty($value)) return $value;
        return $this->computeHashid();
    }

    protected function computeHashid()
    {
        return app(\Hashids\Hashids::class)->encode($this->getKey());
    }

    protected function hasHashidColumn()
    {
        $class = static::class;

        if (!array_key_exists($class, self::$hashidColumnCache)) {
            self::$hashidColumnCache[$class] = \Illuminate\Support\Facades\Schema::hasColumn($this->getTable(), 'hashid');
        }

        return self::$hashidColumnCache[$class];
    }

    public static function decodeId($hashid)
    {
        $decoded = app(\Hashids\Hashids::class)->decode($hashid);
        return $decoded ? $decoded[0] : null;
    }
}