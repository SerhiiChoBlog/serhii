<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SignInMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $random = random_int(100000, 999999);

        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'secret' => 'HZcIFEU4sa554dcd7ad42129f3d69ed1849b50d5fgEg' . $random,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'sign_in_method' => SignInMethod::EMAIL,
            'avatar' => User::DEFAULT_IMAGE_NAME,
        ];
    }

    /**
     * @return Factory<User>
     */
    public function unverified(): Factory
    {
        return $this->state(fn (array $attributes) => ['email_verified_at' => null]);
    }
}
