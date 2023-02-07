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
            'visitor_id' => null,
            'user_id' => null,
            'comment_id' => null,
            'comment' => $this->faker->text(100),
            'is_approved' => true,
            'created_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
