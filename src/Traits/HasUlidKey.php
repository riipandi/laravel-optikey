<?php

namespace Riipandi\LaravelOptiKey\Traits;

trait HasUlidKey
{
    public static function bootHasUlidKey()
    {
        static::creating(function ($model) {
            $optiKeyFieldName = $model->getoptiKeyFieldName();
            $ulidLowerCase = $model->getUlidLowerCase();

            if (empty($model->{$optiKeyFieldName})) {
                $model->{$optiKeyFieldName} = self::generateUlid($ulidLowerCase);
            }
        });
    }

    public function getoptiKeyFieldName()
    {
        if (! empty($this->optiKeyFieldName)) {
            return $this->optiKeyFieldName;
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
        return $query->where($this->getoptiKeyFieldName(), $ulid);
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
