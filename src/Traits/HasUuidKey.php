<?php

namespace Riipandi\LaravelOptiKey\Traits;

use Illuminate\Support\Str;

trait HasUuidKey
{
    public static function bootHasUuidKey()
    {
        static::creating(function ($model) {
            $optiKeyFieldName = $model->getOptiKeyFieldName();

            if (empty($model->$optiKeyFieldName)) {
                $model->$optiKeyFieldName = self::generateUuid();
            }
        });
    }

    public function getOptiKeyFieldName()
    {
        if (! empty($this->optiKeyFieldName)) {
            return $this->optiKeyFieldName;
        }

        return 'uuid';
    }

    public static function generateUuid()
    {
        return (string) Str::orderedUuid();
    }

    public function scopeByOptiKey($query, $uid)
    {
        return $query->where($this->getOptiKeyFieldName(), $uid);
    }

    public static function findByOptiKey($uid)
    {
        return static::byOptiKey($uid)->first();
    }
}
