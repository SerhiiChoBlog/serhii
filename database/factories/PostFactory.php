<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'title' => $title,
            'intro' => $this->faker->sentence(15),
            'slug' => Str::slug($title),
            'is_published' => false,
        ];
    }

    public function published(): static
    {
        return $this->state(
            fn (array $attributes): array => [
                'is_published' => true,
            ],
        );
    }

    public function title(string $title): static
    {
        return $this->state(
            fn (array $attributes) => [
                'title' => $title,
                'slug' => str($title)->slug(),
            ],
        );
    }
}
