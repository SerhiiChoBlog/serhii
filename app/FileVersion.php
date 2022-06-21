<?php

declare(strict_types=1);

namespace App;

use Illuminate\Support\Facades\File;

class FileVersion
{
    public static function append(string $public_path): string
    {
        $version = File::lastModified(public_path() . $public_path);
        return "$public_path?v=$version";
    }
}
