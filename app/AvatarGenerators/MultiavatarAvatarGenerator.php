<?php

declare(strict_types=1);

namespace App\AvatarGenerators;

use Multiavatar;

class MultiavatarAvatarGenerator implements AvatarGenerator
{
    public function __construct(protected string $email)
    {
    }

    public function generate(): ?string
    {
        $multiavatar = new Multiavatar();
        return $multiavatar($this->email, null, null);
    }
}
