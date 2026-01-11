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
        $domain = 'https://serhiicho.com';

        $result = str_replace('http://', 'https://', $result);
        $result = str_replace('https://www.', 'https://', $result);
        $result = str_replace('https://serhii.shobar.com.ua', $domain, $result);
        $result = str_replace('https://cho.shobar.com.ua', $domain, $result);
        $result = str_replace('https://serhii.io', $domain, $result);

        return $result;
    }
}
