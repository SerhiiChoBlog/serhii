<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class TagFactory extends Factory
{
    public function definition(): array
    {
        $random_str = Str::random(5);
        $tags = $this->getTags();

        $tag = $tags->shuffle()->first()->append("-$random_str");
        $title = $tag->title()->toString();

        return [
            'name' => $tag->toString(),
            'title' => $title,
            'description' => "The description of the $title",
            'color' => $this->faker->hexColor(),
        ];
    }

    /**
     * @return Collection<int, Stringable>
     */
    private function getTags(): Collection
    {
        return collect([
            str('javascript'),
            str('typescript'),
            str('clean-code'),
            str('philosophy'),
            str('tutorials'),
            str('wordpress'),
            str('agnostic'),
            str('stories'),
            str('laravel'),
            str('react'),
            str('linux'),
            str('bot'),
            str('seo'),
            str('vue'),
            str('php'),
        ]);
    }
}
