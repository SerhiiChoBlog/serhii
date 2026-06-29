<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\BadgeName;
use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        Badge::query()->insert([
            [
                'name' => BadgeName::VERIFIED->value,
                'description' => 'Verified email address',
                'icon' => 'verified.png',
            ],
            [
                'name' => BadgeName::COMMENTATOR->value,
                'description' => 'Posted 10 verified comments',
                'icon' => 'commentator.png',
            ],
            [
                'name' => BadgeName::LOVELY->value,
                'description' => 'Likes 10 articles',
                'icon' => 'lovely.png',
            ],
        ]);
    }
}
