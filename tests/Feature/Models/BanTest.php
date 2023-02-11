<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Ban;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BanTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_ban_can_be_created(): void
    {
        $user = User::factory()->create();

        $attributes = [
            'user_id' => $user->id,
            'comment' => 'This person uses swear words in their comments',
        ];

        Ban::factory()->create($attributes);

        $this->assertDatabaseHas('bans', $attributes);
    }

    public function test_ban_has_user_associated(): void
    {
        $user = User::factory()->create();

        $attributes = [
            'user_id' => $user->id,
            'comment' => 'This person uses swear words in their comments',
        ];

        $ban = Ban::factory()->create($attributes);

        $this->assertSame($user->id, $ban->user->id);
    }
}
