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
}
