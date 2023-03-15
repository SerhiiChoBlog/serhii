<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Series;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Series>
 */
class SeriesFactory extends Factory
{
    protected $model = Series::class;

    /**
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        $rand = random_int(1, 99999);

        return [
            'title' => "Learn JS {$rand}",
            'intro' => 'Learn JavaScript in 30 days',
            'slug' => "learn-js-{$rand}",
            'description' => 'Learn JavaScript in 30 days and become a JavaScript developer in 2023',
        ];
    }
}
