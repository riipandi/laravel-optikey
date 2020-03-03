<?php

namespace Riipandi\LaravelOptiKey\Traits;

trait HasUlidKey
{
    public static function bootHasUlidKey()
    {
        static::creating(function ($model) {

            $ulidFieldName = $model->getUlidFieldName();
            $ulidLowerCase = $model->getUlidLowerCase();

            if (empty($model->{$ulidFieldName})) {
                $model->{$ulidFieldName} = self::generateUlid($ulidLowerCase);
            }

        });
    }

    public function getUlidFieldName()
    {
        if (! empty($this->ulidFieldName)) {
            return $this->ulidFieldName;
        }

        return 'ulid';
    }

    public function getUlidLowerCase()
    {
        if (! empty($this->ulidLowerCase)) {
            return $this->ulidLowerCase;
        }

        return false;
    }

    public function scopeByUlid($query, $ulid)
    {
        return $query->where($this->getUlidFieldName(), $ulid);
    }

    public static function findByUlid($ulid)
    {
        return static::byUlid($ulid)->first();
    }

    protected static function generateUlid($lowercase = false)
    {
        return (string) \Ulid\Ulid::generate($lowercase);
    }
}
