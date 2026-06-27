<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostLike>
 */
class PostLikeFactory extends Factory
{
    protected $model = PostLike::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    public function withPost(): self
    {
        return $this->state(function (array $attributes) {
            return ['post_id' => Post::factory()];
        });
    }
}
