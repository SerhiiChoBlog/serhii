<?php

declare(strict_types=1);

namespace App;

class CanonicalTag
{
    public function __toString(): string
    {
        return sprintf('<link rel="canonical" href="%s" />', $this->getUrl());
    }

    private function getUrl(): string
    {
        $result = request()->fullUrl();

        $result = str_replace('http://', 'https://', $result);
        $result = str_replace('https://www.', 'https://', $result);
        $result = str_replace('https://serhii.shobar.com.ua', 'https://serhiicho.com', $result);
        $result = str_replace('https://cho.shobar.com.ua', 'https://serhiicho.com', $result);

        return $result;
    }
}
