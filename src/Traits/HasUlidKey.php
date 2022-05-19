<?php

namespace Riipandi\LaravelOptiKey\Traits;

trait HasUlidKey
{
    public static function bootHasUlidKey()
    {
        static::creating(function ($model) {
            $optiKeyFieldName = $model->getOptiKeyFieldName();
            $optiKeyLowerCase = $model->getOptiKeyLowerCase();
            $optiKeyPrefix = $model->getOptiKeyPrefix();

            if (empty($model->{$optiKeyFieldName})) {
                $model->{$optiKeyFieldName} = self::generateId($optiKeyPrefix, $optiKeyLowerCase);
            }
        });
    }

    public function getOptiKeyFieldName()
    {
        if (! empty($this->optiKeyFieldName)) {
            return $this->optiKeyFieldName;
        }

        return 'ulid';
    }

    public function getOptiKeyLowerCase()
    {
        if (! empty($this->optiKeyLowerCase)) {
            return $this->optiKeyLowerCase;
        }

        return false;
    }

    public function getOptiKeyPrefix()
    {
        if (! empty($this->optiKeyPrefix)) {
            return $this->optiKeyPrefix;
        }

        return '';
    }

    public function scopeByOptiKey($query, $uid)
    {
        return $query->where($this->getOptiKeyFieldName(), $uid);
    }

    public static function findByOptiKey($uid)
    {
        return static::byOptiKey($uid)->first();
    }

    protected static function generateId($prefix = '', $lowercase = false)
    {
        $generated = \Ulid\Ulid::generate($lowercase);

        return (string) $prefix ? $prefix.$generated : $generated;
    }
}
