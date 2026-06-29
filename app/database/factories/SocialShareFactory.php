<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SocialName;
use App\Models\SocialShare;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SocialShare>
 */
class SocialShareFactory extends Factory
{
    protected $model = SocialShare::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $social_names = SocialName::all();
        $random_social = $social_names[array_rand($social_names)];

        return [
            'social' => $random_social,
        ];
    }
}
