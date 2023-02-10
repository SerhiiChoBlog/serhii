<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        Badge::query()->insert([
            [
                'name' => 'Verified',
                'description' => 'Verified email address',
                'icon' => 'verified.webp',
            ],
            [
                'name' => 'Commentator',
                'description' => 'Posted 5 verified comments',
                'icon' => 'commentator.webp',
            ],
            [
                'name' => 'Likeable',
                'description' => 'Liked 5 articles',
                'icon' => 'likeable.webp',
            ],
        ]);
    }
}
