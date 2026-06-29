<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Referrer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReferrerSeeder extends Seeder
{
    public function run(): void
    {
        Referrer::query()->create([
            'name' => 'Jiskelo',
            'site' => 'https://jiskelo.dev',
            'hits' => 1,
            'hash' => Str::random(5)
        ]);

        Referrer::query()->create([
            'name' => 'Shobar',
            'site' => 'https://shobar.com.ua',
            'hits' => 1,
            'hash' => Str::random(5)
        ]);
    }
}
