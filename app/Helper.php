<?php

namespace Portfolio;

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
}
