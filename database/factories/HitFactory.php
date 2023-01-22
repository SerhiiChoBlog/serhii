<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Hit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hit>
 */
class HitFactory extends Factory
{
    protected $model = Hit::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => 0,
        ];
    }
}
