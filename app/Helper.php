<?php

namespace Portfolio;

use Exception;

class Helper
{
    public static function fileVersion(string $file): string
    {
        try {
            return filemtime(get_template_directory() . "/{$file}");
        } catch (Exception $e) {
            return '';
        }
    }

    public static function getDirUri(string $path): string
    {
        return get_template_directory_uri() . "/{$path}";
    }

    /**
     * Helper for get_template_directory() function, to require
     * all files from inc folder
     *
     * @param array $paths
     * @return void
     */
    public static function requireIncFiles(array $paths): void
    {
        array_map(function ($path) {
            require_once get_template_directory() . "/inc/{$path}.php";
        }, $paths);
    }
}
