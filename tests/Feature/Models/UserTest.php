<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Enums\BadgeName;
use App\Enums\UserRole;
use App\Models\Badge;
use App\Models\Ban;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use LazilyRefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
    }

    public function testUserCanBeCreated(): void
    {
        $this->assertDatabaseCount('users', 1);
    }

    public function testUserHasRolesAssociated(): void
    {
        /** @var Role $role */
        $role = Role::factory()->create(['name' => UserRole::ADMIN]);

        $this->user->roles()->attach([$role->id]);

        $this->assertCount(1, $this->user->roles);
    }

    public function testMethodReturnsTrueIfUserHasAdminRole(): void
    {
        /** @var Role $role */
        $role = Role::factory()->create(['name' => 'admin']);

        $this->user->roles()->attach([$role->id]);

        $this->assertTrue($this->user->hasRole(UserRole::ADMIN));
    }

    public function testMethodReturnsFalseIfUserDoesntHaveAdminRole(): void
    {
        $this->assertFalse($this->user->hasRole(UserRole::ADMIN));
    }

    public function testHasRelationWithBadges(): void
    {
        $badge = Badge::factory()->create();

        $this->user->badges()->attach([$badge->id]);

        $this->assertCount(1, $this->user->badges);
    }

    public function testGiveBadgeMethodAddBadge(): void
    {
        Badge::factory()->create(['name' => BadgeName::LOVELY]);

        $this->user->giveBadge(BadgeName::LOVELY);

        $badge = $this->user->badges()->first();

        $this->assertSame(BadgeName::LOVELY, $badge->name);
    }

    public function testGiveBadgeMethodSkipsTheOperationIfNoBadgeFound(): void
    {
        $this->user->giveBadge(BadgeName::LOVELY);
        $this->assertSame(0, $this->user->badges()->count());
    }

    public function testUserHasRelationshipWithBan(): void
    {
        $ban = Ban::factory()->create(['user_id' => $this->user->id]);
        $this->assertNotNull($this->user->ban);
    }

    public function testMethodHasBadgeReturnFalseIfThereIsNoBadge(): void
    {
        Badge::factory()->create(['name' => BadgeName::LOVELY]);
        $this->assertFalse($this->user->hasBadge(BadgeName::LOVELY));
    }

    public function testMethodHasBadgeReturnTrueIfThereIsBadge(): void
    {
        Badge::factory()->create(['name' => BadgeName::LOVELY]);

        $this->user->giveBadge(BadgeName::LOVELY);

        $this->assertTrue($this->user->hasBadge(BadgeName::LOVELY));
    }

    public function testWeCanGetPostsThatUserLiked(): void
    {
        /** @var Post $post */
        $post = Post::factory()->published()->create();

        Post::factory()->published()->create();

        $this->user->postLikes()->create(['post_id' => $post->id]);

        $this->assertCount(1, $this->user->likedPosts);
        $this->assertSame($post->id, $this->user->likedPosts->first()->id);
    }
}
