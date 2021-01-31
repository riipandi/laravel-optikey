<?php

namespace Riipandi\LaravelOptiKey\Traits;

trait UlidAsPrimaryKey
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
