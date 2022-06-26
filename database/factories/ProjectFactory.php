<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
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
