<?php

namespace Riipandi\LaravelOptiKey\Traits;

trait UuidAsPrimaryKey
{
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
