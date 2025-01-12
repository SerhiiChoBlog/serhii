<?php

declare(strict_types=1);

namespace App\AvatarGenerators;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GlavatarAvatarGenerator implements AvatarGenerator
{
    public const URL = 'https://www.gravatar.com/avatar/';

    public function __construct(protected string $email)
    {
    }

    public function generate(): string|null
    {
        /** @var Response $response */
        $response = Http::get($this->getUrl());

        if ($response->failed()) {
            return null;
        }

        return $response->body();
    }

    public function getUrl(): string
    {
        $hash = md5(strtolower($this->email));
        return self::URL . "{$hash}?s=200&d=404";
    }
}
