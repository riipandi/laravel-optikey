<?php

namespace Riipandi\LaravelOptiKey\Traits;

use Hidehalo\Nanoid\Client;

trait HasNanoidKey
{
    public static function bootHasNanoidKey()
    {
        static::creating(function ($model) {
            $optiKeyFieldName = $model->getOptiKeyFieldName();
            $optiKeyLowerCase = $model->getOptiKeyLowerCase();
            $optiKeyPrefix = $model->getOptiKeyPrefix();

            if (empty($model->{$optiKeyFieldName})) {
                $model->{$optiKeyFieldName} = self::generateId(16, $optiKeyPrefix, $optiKeyLowerCase);
            }
        });
    }

    public function getOptiKeyFieldName()
    {
        if (! empty($this->optiKeyFieldName)) {
            return $this->optiKeyFieldName;
        }

        return 'nanoid';
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

    protected static function generateId($length = 16, $prefix = '', $lowercase = false)
    {
        $client = new Client();
        $customAlphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $uid = $client->formattedId($alphabet = $customAlphabet, $size = $length);
        $generated = $prefix ? $prefix.$uid : $uid;
        $finalStr = $lowercase == true ? strtolower($generated) : $generated;

        return (string) $finalStr;
    }
}
