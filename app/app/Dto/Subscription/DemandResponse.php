<?php

declare(strict_types=1);

namespace App\Dto\Subscription;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<int, array{
 *     success: bool,
 *     message: string,
 * }>
 */
class DemandResponse implements Arrayable
{
    public function __construct(public bool $success, public string $message)
    {
    }

    /**
     * @return array{success: bool, message: string}
     */
    public function toArray(): array
    {
        return (array) $this;
    }
}
