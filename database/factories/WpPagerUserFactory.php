<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\WpPagerUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WpPagerUser>
 */
class WpPagerUserFactory extends Factory
{
    protected $model = WpPagerUser::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'host' => 'example.com',
            'is_active' => true,
        ];
    }
}
