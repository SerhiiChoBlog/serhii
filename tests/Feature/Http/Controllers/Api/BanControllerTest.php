<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Ban;
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

    public function testAdminCanBanUser(): void
    {
        $user = $this->createUser();
        $admin = $this->createAdmin();

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->actingAs($admin, 'admin')
            ->postJson(self::BAN_URI, $params)
            ->assertOk();

        $this->assertDatabaseHas('bans', $params);
    }

    public function testUserCannotBanUser(): void
    {
        $user = $this->createUser();
        $user2 = $this->createUser();

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->actingAs($user2, 'user')
            ->postJson(self::BAN_URI, $params)
            ->assertUnauthorized();

        $this->assertDatabaseEMpty('bans');
    }

    public function testGuestCannotBanUser(): void
    {
        $user = $this->createUser();

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->postJson(self::BAN_URI, $params)
            ->assertUnauthorized();

        $this->assertDatabaseEMpty('bans');
    }

    public function testBanningUserSetsRememberTokenToNull(): void
    {
        $user = User::factory()->create(['remember_token' => 'token']);
        $admin = $this->createAdmin();

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $this->actingAs($admin, 'admin')
            ->postJson(self::BAN_URI, $params)
            ->assertOk();

        $this->assertNull($user->fresh()?->remember_token);
        $this->assertDatabaseHas('bans', $params);
    }

    public function testItDoesntCreateSecondBanIfUserIsAlreadyBanned(): void
    {
        $user = User::factory()->create(['remember_token' => 'token']);

        $params = [
            'user_id' => $user->id,
            'comment' => 'This is my comment',
        ];

        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->postJson(self::BAN_URI, $params)
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->postJson(self::BAN_URI, $params)
            ->assertOk();

        $this->assertDatabaseCount('bans', 1);
    }

    public function testUserCommentsBecomeNotApprovedWhenWePassAFlag(): void
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
            ->postJson(self::BAN_URI, $params);

        $comments = $user
            ->comments()
            ->where('is_approved', false)
            ->count();

        $this->assertSame(3, $comments);

        $this->assertDatabaseCount('bans', 1);
    }


    public function testUserCommentsDoesntBecomeNotApprovedWhenWeDontPassAFlag(): void
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
            ->postJson(self::BAN_URI, $params);

        $comments = $user
            ->comments()
            ->where('is_approved', true)
            ->count();

        $this->assertSame(3, $comments);

        $this->assertDatabaseCount('bans', 1);
    }

    public function testAdminCanUnbanUser(): void
    {
        $user = $this->createUser();
        Ban::factory()->create(['user_id' => $user]);

        $this->assertDatabaseCount('bans', 1);

        $admin = $this->createAdmin();

        $params = ['user_id' => $user->id];

        $this->actingAs($admin, 'admin')
            ->postJson(self::UNBAN_URI, $params)
            ->assertOk();

        $this->assertDatabaseEmpty('bans');
    }
}
