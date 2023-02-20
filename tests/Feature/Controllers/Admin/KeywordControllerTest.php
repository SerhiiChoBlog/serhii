<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Admin;

use App\Models\Keyword;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class KeywordControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const SEARCH_URI = '/admin/ajax/keywords/search/';
    private const STORE_URI = '/admin/ajax/keywords';

    private User $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
    }

    public function testCanSearchKeyword(): void
    {
        $andrew_keyword = Keyword::factory()->create(['name' => 'andrew']);
        $tate_keyword = Keyword::factory()->create(['name' => 'tate']);

        $resp = $this->actingAs($this->admin, 'admin')
            ->json('get', self::SEARCH_URI . 'andrew')
            ->assertOk();

        $resp->assertJson([[
            'id' => $andrew_keyword->id,
            'name' => $andrew_keyword->name,
        ]]);
    }

    public function testSearchingKeywordReturnsMultipleKeywords(): void
    {
        $andrew_keyword = Keyword::factory()->create(['name' => 'andrewtate']);
        $tristan_keyword = Keyword::factory()->create(['name' => 'tristantate']);

        $resp = $this->actingAs($this->admin, 'admin')
            ->json('get', self::SEARCH_URI . 'tate')
            ->assertOk();

        $resp->assertJson([
            [
                'id' => $andrew_keyword->id,
                'name' => $andrew_keyword->name,
            ],
            [
                'id' => $tristan_keyword->id,
                'name' => $tristan_keyword->name,
            ],
        ]);
    }

    public function testCreatesKeywordWhenItDoesntAlreadyExist(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $this->actingAs($this->admin, 'admin')
            ->json('post', self::STORE_URI, ['name' => 'andrew', 'post_id' => $post->id])
            ->assertOk();

        $this->assertDatabaseHas('keywords', ['name' => 'andrew']);
    }

    public function testDoesntCreateKeywordWhenItAlreadyExist(): void
    {
        Keyword::factory()->create(['name' => 'anna']);

        /** @var Post $post */
        $post = Post::factory()->create();

        $this->actingAs($this->admin, 'admin')
            ->json('post', self::STORE_URI, ['name' => 'anna', 'post_id' => $post->id])
            ->assertOk();

        $this->assertDatabaseCount('keywords', 1);
        $this->assertDatabaseHas('keywords', ['name' => 'anna']);
    }

    public function testAddingKeywordConnectsPost(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();
        $keyword = Keyword::factory()->create(['name' => 'anna']);

        $this->actingAs($this->admin, 'admin')
            ->json('post', self::STORE_URI, ['name' => 'anna', 'post_id' => $post->id])
            ->assertOk();

        $post_keywords = $post->keywords;
        $keyword_posts = $keyword->posts;

        $this->assertCount(1, $post_keywords);
        $this->assertCount(1, $keyword_posts);

        $this->assertInstanceOf(Keyword::class, $post_keywords->first());
        $this->assertInstanceOf(Post::class, $keyword_posts->first());
    }
}
