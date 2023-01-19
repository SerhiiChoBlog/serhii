<?php

declare(strict_types=1);

namespace App\AvatarGenerators;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GlavatarAvatarGenerator implements AvatarGenerator
{
    public function __construct(protected string $email)
    {
    }

    public function generate(): ?string
    {
        $hash = md5(strtolower($this->email));
        $url = "https://www.gravatar.com/avatar/{$hash}?s=200&d=404";

        /** @var Response $response */
        $response = Http::get($url);

        if ($response->failed()) {
            return null;
        }

        return $response->body();
    }
}
