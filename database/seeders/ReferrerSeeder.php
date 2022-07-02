<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Referrer;
use Illuminate\Database\Seeder;

class ReferrerSeeder extends Seeder
{
    public function run(): void
    {
        Referrer::factory()->create([
            'name' => 'Jiskelo',
            'site' => 'https://jiskelo.dev',
            'hits' => 1,
        ]);

        Referrer::factory()->create([
            'name' => 'Shobar',
            'site' => 'https://shobar.com.ua',
            'hits' => 1,
        ]);
    }
}
