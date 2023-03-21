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
                'description' => 'Posted 5 verified comments',
                'icon' => 'commentator.png',
            ],
            [
                'name' => BadgeName::LOVELY->value,
                'description' => 'Liked 5 articles',
                'icon' => 'lovely.png',
            ],
        ]);
    }
}
