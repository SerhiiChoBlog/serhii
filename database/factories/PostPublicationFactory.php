<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PostPublication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostPublication>
 */
class PostPublicationFactory extends Factory
{
    protected $model = PostPublication::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
