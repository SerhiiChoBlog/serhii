<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

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
        $this->post = Post::factory()->create();
        $this->uri = "/api/social-shares/{$this->post->id}";
        $this->visitor = Visitor::factory()->create();
    }

    public function test_we_can_save_social_share_in_database(): void
    {
        $params = ['social' => 'telegram'];

        $this->json('post', $this->uri, $params, [
            'REMOTE_ADDR' => $this->visitor->ip
        ]);

        $this->assertDatabaseHas('social_shares', [
            'post_id' => $this->post->id,
            'visitor_id' => $this->visitor->id,
            'social' => $params['social']
        ]);
    }
}
