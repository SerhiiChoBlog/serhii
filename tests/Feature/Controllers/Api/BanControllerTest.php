<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BanControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const BAN_URI = '/admin/ajax/bans/ban';
    private const UNBAN_URI = '/admin/ajax/bans/unban';

    public function test_admin_can_ban_user(): void
    {
        $user = User::factory()->create();
        $admin = $this->createAdmin();

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->actingAs($admin, 'admin')
            ->post(self::BAN_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('bans', $params);
    }

    public function test_user_cannot_ban_user(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->actingAs($user2, 'user')
            ->post(self::BAN_URI, $params)
            ->assertStatus(302);

        $this->assertDatabaseEMpty('bans');
    }

    public function test_guest_cannot_ban_user(): void
    {
        $user = User::factory()->create();

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->post(self::BAN_URI, $params)
            ->assertStatus(302);

        $this->assertDatabaseEMpty('bans');
    }

    public function test_banning_user_sets_remember_token_to_null(): void
    {
        $user = User::factory()->create(['remember_token' => 'token']);
        $admin = $this->createAdmin();

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->actingAs($admin, 'admin')
            ->post(self::BAN_URI, $params)
            ->assertOk();

        $this->assertNull($user->fresh()->remember_token);
        $this->assertDatabaseHas('bans', $params);
    }

    public function test_it_doesnt_create_second_ban_if_user_is_already_banned(): void
    {
        $user = User::factory()->create(['remember_token' => 'token']);

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->post(self::BAN_URI, $params)
            ->assertOk();

        $this->actingAs($admin, 'admin')
             ->post(self::BAN_URI, $params)
             ->assertOk();

        $this->assertDatabaseCount('bans', 1);
    }

    public function test_user_comments_become_not_approved_when_we_pass_a_flag(): void
    {
        $user = User::factory()->create(['remember_token' => 'token']);
        $post = Post::factory()->create();

        Comment::factory()->count(3)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'is_approved' => true,
        ]);

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
            'disapprove_comments' => true,
        ];

        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->post(self::BAN_URI, $params);

        $comments = $user
            ->comments()
            ->where('is_approved', false)
            ->count();

        $this->assertSame(3, $comments);

        $this->assertDatabaseCount('bans', 1);
    }


    public function test_user_comments_doesnt_become_not_approved_when_we_dont_pass_a_flag(): void
    {
        $user = User::factory()->create(['remember_token' => 'token']);
        $post = Post::factory()->create();

        Comment::factory()->count(3)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'is_approved' => true,
        ]);

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
            'disapprove_comments' => false,
        ];

        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
             ->post(self::BAN_URI, $params);

        $comments = $user
            ->comments()
            ->where('is_approved', true)
            ->count();

        $this->assertSame(3, $comments);

        $this->assertDatabaseCount('bans', 1);
    }
}
