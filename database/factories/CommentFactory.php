<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => null,
            'user_id' => null,
            'comment_id' => null,
            'comment' => $this->faker->text(100),
            'is_approved' => true,
            'created_at' => now(),
        ];
    }

    public function withPost(): self
    {
        return $this->state(function (array $attributes) {
            return ['post_id' => PostFactory::new()];
        });
    }
}
