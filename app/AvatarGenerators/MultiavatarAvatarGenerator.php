<?php

declare(strict_types=1);

namespace App\AvatarGenerators;

use Multiavatar;

class MultiavatarAvatarGenerator implements AvatarGenerator
{
    public function __construct(protected string $email)
    {
    }

    public function generate(): string|null
    {
        $multiavatar = new Multiavatar();
        $id = "serhii{$this->email}cho";

        return $multiavatar($id, null, null);
    }
}
