<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $num = random_int(1, 99999);

        return [
            'title' => "Some random title for the post {$num}",
            'intro' => 'This is a random intro for the post with not much meaning and pretty short. I can write a longer one but that is find',
            'slug' => "some-random-title-for-the-post-{$num}",
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
