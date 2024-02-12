<?php

namespace LaravelServicePattern;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelServicePattern\LaravelServicePattern
 */
class LaravelServicePatternFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-service-pattern';
    }
}
