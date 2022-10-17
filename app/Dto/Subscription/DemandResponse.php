<?php

declare(strict_types=1);

namespace App\Dto\Subscription;

use Illuminate\Contracts\Support\Arrayable;

class DemandResponse implements Arrayable
{
    public function __construct(public bool $success, public string $message)
    {
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
