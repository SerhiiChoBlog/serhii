<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $title = $this->faker->title();

        return [
            'title' => $title,
            'intro' => $this->faker->paragraph(),
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
            fn(array $attributes) => [
                'title' => $title,
                'slug' => str($title)->slug(),
            ],
        );
    }
}
