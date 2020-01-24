<?php

namespace Riipandi\LaravelOptiKey\Traits;

trait HasUlidKey
{
    public static function bootHasUlidKey()
    {
        static::creating(function ($model) {
            $ulidFieldName = $model->getUlidFieldName();
            if (empty($model->{$ulidFieldName})) {
                $model->{$ulidFieldName} = self::generateUlid();
            }
        });
    }

    public function getUlidFieldName()
    {
        if (!empty($this->ulidFieldName)) {
            return $this->ulidFieldName;
        }

        return 'ulid';
    }

    public function scopeByUlid($query, $ulid)
    {
        return $query->where($this->getUlidFieldName(), $ulid);
    }

    public static function findByUlid($ulid)
    {
        return static::byUlid($ulid)->first();
    }

    protected static function generateUlid()
    {
        return (string) \Ulid\Ulid::generate();
    }
}
