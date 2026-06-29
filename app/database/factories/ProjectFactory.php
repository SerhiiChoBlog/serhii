<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'name' => 'some-name',
            'title' => 'Some name',
            'url' => 'http://some-url.com/nice',
            'content' => $this->faker->paragraph(),
            'description' => $this->faker->paragraph(),
            'language' => ['php', 'javascript', 'typescript', 'css', 'go'][random_int(0, 4)],
            'stars' => random_int(0, 100),
            'created_at' => '2021-01-01 10:00:00',
        ];
    }
}
