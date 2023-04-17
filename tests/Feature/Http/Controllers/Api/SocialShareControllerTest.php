<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api;

use App\Enums\SocialName;
use App\Models\Post;
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

    public function testWeCanSaveSocialShareInDatabase(): void
    {
        $params = ['social' => SocialName::TELEGRAM->value];

        $this->postJson($this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->assertDatabaseHas('social_shares', [
            'post_id' => $this->post->id,
            'user_id' => null,
            'visitor_id' => $this->visitor->id,
            'social' => $params['social'],
        ]);
    }

    public function testWeCanSaveSocialShareInDatabaseWithUserId(): void
    {
        $user = $this->createUser();

        $params = [
            'social' => SocialName::LINKEDIN->value,
            'secret' => $user->secret,
        ];

        $this->postJson($this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->assertDatabaseHas('social_shares', [
            'post_id' => $this->post->id,
            'user_id' => $user->id,
            'visitor_id' => $this->visitor->id,
            'social' => $params['social'],
        ]);
    }

    public function testWeCannotCreateTheSameSocialShareTwice(): void
    {
        $params = ['social' => SocialName::LINKEDIN];

        $this->postJson($this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->postJson($this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->assertDatabaseCount('social_shares', 1);
    }

    public function testYouCannotSubmitUnknownSocialName(): void
    {
        $params = ['social' => 'unknown'];

        $this->postJson($this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->assertDatabaseEmpty('social_shares');
    }

    public function testAdminShareDoesntCount(): void
    {
        $admin = $this->createAdmin();

        $params = [
            'social' => SocialName::LINKEDIN,
            'secret' => $admin->secret,
        ];

        $this->postJson($this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip,
        ]);

        $this->assertDatabaseEmpty('social_shares');
    }
}
