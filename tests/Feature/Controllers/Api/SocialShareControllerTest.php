<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Enums\SocialName;
use App\Models\Post;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class SocialShareControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private Post $post;
    private Visitor $visitor;
    private string $uri = '';

    public function setUp(): void
    {
        parent::setUp();
        $this->post    = Post::factory()->create();
        $this->uri     = "/api/social-shares/{$this->post->id}";
        $this->visitor = Visitor::factory()->create();
    }

    public function test_we_can_save_social_share_in_database(): void
    {
        $params = ['social' => SocialName::TELEGRAM];

        $this->json('post', $this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->assertDatabaseHas('social_shares', [
            'post_id' => $this->post->id,
            'user_id' => null,
            'visitor_id' => $this->visitor->id,
            'social' => $params['social'],
        ]);
    }

    public function test_we_can_save_social_share_in_database_with_user_id(): void
    {
        $user = User::factory()->create();

        $params = [
            'social' => SocialName::LINKEDIN,
            'secret' => $user->secret,
        ];

        $this->json('post', $this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->assertDatabaseHas('social_shares', [
            'post_id' => $this->post->id,
            'user_id' => $user->id,
            'visitor_id' => $this->visitor->id,
            'social' => $params['social'],
        ]);
    }

    public function test_we_cannot_create_the_same_social_share_twice(): void
    {
        $params = ['social' => SocialName::LINKEDIN];

        $this->json('post', $this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->json('post', $this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->assertDatabaseCount('social_shares', 1);
    }

    public function test_you_cannot_submit_unknown_social_name(): void
    {
        $params = ['social' => 'unknown'];

        $this->json('post', $this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->assertDatabaseEmpty('social_shares');
    }

    public function test_admin_share_doesnt_count(): void
    {
        $admin = $this->createAdmin();

        $params = [
            'social' => SocialName::LINKEDIN,
            'secret' => $admin->secret,
        ];

        $this->json('post', $this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->assertDatabaseEmpty('social_shares');
    }
}
