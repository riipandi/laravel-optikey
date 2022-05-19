<?php

namespace Riipandi\LaravelOptiKey\Traits;

trait OptiKeyAsPrimary
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
