<?php

namespace Core\Abstracts;

abstract class Facade
{
    abstract protected static function getFacadeAccessor(): mixed;

    protected static function resolveInstance()
    {
        $class = static::getFacadeAccessor();
        if (is_string($class)) {
            return new $class();
        } else {
            return $class;
        }
    }

    public static function __callStatic($method, $args)
    {
        return static::resolveInstance()->$method(...$args);
    }
}