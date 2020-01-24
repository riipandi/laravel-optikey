<?php

namespace Riipandi\LaravelOptiKey\Traits;

use Illuminate\Support\Str;

trait HasUuidKey
{
    public static function bootHasUuidKey()
    {
        static::creating(function ($model) {
            $uuidFieldName = $model->getUuidFieldName();
            if (empty($model->$uuidFieldName)) {
                $model->$uuidFieldName = self::generateUuid();
            }
        });
    }

    public function getUuidFieldName()
    {
        if (! empty($this->uuidFieldName)) {
            return $this->uuidFieldName;
        }

        return 'uuid';
    }

    public static function generateUuid()
    {
        return (string) Str::uuid();
    }

    public function scopeByUuid($query, $uuid)
    {
        return $query->where($this->getUuidFieldName(), $uuid);
    }

    public static function findByUuid($uuid)
    {
        return static::byUuid($uuid)->first();
    }
}
