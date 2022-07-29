<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Hit;
use Illuminate\Database\Eloquent\Factories\Factory;

class HitFactory extends Factory
{
    protected $model = Hit::class;

    public function definition(): array
    {
        return [
            'amount' => 0,
        ];
    }
}
