<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Enums\SocialName;
use App\Models\Post;
use App\Models\SocialShare;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class SocialShareTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $post = Post::factory()->create();
        $visitor = Visitor::factory()->create();

        $share = SocialShare::factory()->create([
            'post_id' => $post->id,
            'visitor_id' => $visitor->id,
        ]);

        $this->assertDatabaseCount('social_shares', 1);

        $this->assertDatabaseHas('social_shares', [
            'id' => $share->id,
            'post_id' => $post->id,
            'visitor_id' => $visitor->id,
            'social' => $share->social,
        ]);
    }

    public function test_social_share_has_relationship_with_post_and_visitor(): void
    {
        $post = Post::factory()->create();
        $visitor = Visitor::factory()->create();

        /** @var SocialShare $share */
        $share = SocialShare::factory()->create([
            'post_id' => $post->id,
            'visitor_id' => $visitor->id,
        ]);

        $this->assertEquals($post->id, $share->post->id);
        $this->assertEquals($visitor->id, $share->visitor->id);
    }

    public function test_social_name_is_enum(): void
    {
        $post = Post::factory()->create();
        $visitor = Visitor::factory()->create();

        /** @var SocialShare $share */
        $share = SocialShare::factory()->create([
            'post_id' => $post->id,
            'visitor_id' => $visitor->id,
        ]);

        $this->assertInstanceOf(SocialName::class, $share->social);
    }
}
