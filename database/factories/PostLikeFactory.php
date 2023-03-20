<?php

declare(strict_types=1);

namespace Database\Factories;

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
}
