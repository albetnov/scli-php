<?php

if (!function_exists('config_path')) {
    /**
     * FUnction that return config path.
     */
    function config_path(?string $file = null): string
    {
        if ($file) return __DIR__ . "/../Config/$file";

        return __DIR__ . "/../Config/";
    }
}

if (!function_exists('config')) {
    /**
     * Function to access config file immadiately
     */
    function config(string $fileName): array
    {
        // Check if the cached config exist, If it's exist use cached config.
        if (file_exists(cache_path($fileName . '.php'))) {
            $config = require cache_path($fileName . '.php');
            return ((array) $config);
        }

        $config = require config_path($fileName . '.php');
        return ((array) $config);
    }
}

if (!function_exists('provider_config')) {
    /**
     * Function to access provider config files.
     */
    function provider_config(): array
    {
        return config('providers');
    }
}

if (!function_exists('base_path')) {
    /**
     * Function to access base path of project
     */
    function base_path(?string $path = null): string
    {
        if ($path) {
            return __DIR__ . '/../../' . $path;
        }
        return __DIR__ . '/../../';
    }
}

if (!function_exists('cache_path')) {
    /**
     * function to access cache path
     */
    function cache_path(?string $fileName = null)
    {
        $path = __DIR__ . "/../Cache/";

        if ($fileName) {
            $path .= $fileName;
        }

        return $path;
    }
}

if (!function_exists('env')) {
    /**
     * Function to get an env, If there's no env you can put
     * optional value.
     */
    function env(string $name, mixed $default = null): mixed
    {
        if (isset($_ENV[$name])) {
            return $_ENV[$name];
        }
        if (!is_null($default)) {
            return $default;
        }

        return false;
    }
}
