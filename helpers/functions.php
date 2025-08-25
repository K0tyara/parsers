<?php
if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        $base = realpath(__DIR__ . '/..');
        return $path ? $base . DIRECTORY_SEPARATOR . $path : $base;
    }
}

if (!function_exists('config')) {
    function config(string $path, mixed $default = null): mixed
    {
        static $configs = [];

        $segments = explode('.', $path);
        $file = array_shift($segments);

        //if config file not download
        if (!isset($configs[$file])) {
            $path = base_path("configs/$file.php");
            if (!file_exists($path)) {
                throw  new LogicException("Config file $path not exist.");
            }

            $configs[$file] = require $path;
        }

        $value = $configs[$file];
        foreach ($segments as $segment) {

            //if we have yet segments and current value not exist or not array will return default value
            if (is_array($value) && array_key_exists($segment, $value)) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }

        return $value;
    }
}