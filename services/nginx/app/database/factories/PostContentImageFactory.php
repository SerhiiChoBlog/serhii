<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PostContentImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostContentImage>
 */
class PostContentImageFactory extends Factory
{
    protected $model = PostContentImage::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uri' => '/storage/posts/content/how-custom-events-in-javascript-can-decouple-your-code-1.png',
            'path' => '/public/posts/content/how-custom-events-in-javascript-can-decouple-your-code-1.png',
        ];
    }
}
