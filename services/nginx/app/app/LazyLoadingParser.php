<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\LazyLoadingConversionException;

final class LazyLoadingParser
{
    /**
     * @throws LazyLoadingConversionException
     */
    public static function makeImagesLazy(string $content): string
    {
        $result = preg_replace('/(<img.*)( src=")(.*?>)/', '$1 data-src="$3', $content);

        if (!$result) {
            throw new LazyLoadingConversionException("Cannot make images lazy");
        }

        return $result;
    }

    /**
     * @throws LazyLoadingConversionException
     */
    public static function makeImagesNotLazy(string $content): string
    {
        $result = preg_replace('/(<img.*)( data-src=")(.*?>)/', '$1 src="$3', $content);

        if (!$result) {
            throw new LazyLoadingConversionException("Cannot make images not lazy");
        }

        return $result;
    }
}
