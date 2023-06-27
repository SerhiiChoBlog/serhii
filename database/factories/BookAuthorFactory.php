<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BookAuthor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookAuthor>
 */
class BookAuthorFactory extends Factory
{
    protected $model = BookAuthor::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
        ];
    }
}
