<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\CacheKey;
use App\Models\Keyword;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class KeywordControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const STORE_URI = '/admin/ajax/keywords';
    private const DELETE_URI = '/admin/ajax/keywords/';

    private User $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
    }

    public function testCreatesKeywordWhenItDoesntAlreadyExist(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $this->actingAs($this->admin, 'admin')
            ->postJson(self::STORE_URI, ['name' => 'skirk', 'post_id' => $post->id])
            ->assertOk();

        $this->assertDatabaseHas('keywords', ['name' => 'skirk']);
    }

    public function testDoesntCreateKeywordWhenItAlreadyExist(): void
    {
        Keyword::factory()->create(['name' => 'anna']);

        /** @var Post $post */
        $post = Post::factory()->create();

        $this->actingAs($this->admin, 'admin')
            ->postJson(self::STORE_URI, ['name' => 'anna', 'post_id' => $post->id])
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
            ->postJson(self::STORE_URI, ['name' => 'anna', 'post_id' => $post->id])
            ->assertOk();

        $post_keywords = $post->keywords;
        $keyword_posts = $keyword->posts;

        $this->assertCount(1, $post_keywords);
        $this->assertCount(1, $keyword_posts);

        $this->assertInstanceOf(Keyword::class, $post_keywords->first());
        $this->assertInstanceOf(Post::class, $keyword_posts->first());
    }

    public function testAddingTheSameKeywordConnectsPostOnlyTheFirstTime(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();
        Keyword::factory()->create(['name' => 'anna']);

        $this->actingAs($this->admin, 'admin')
            ->postJson(self::STORE_URI, ['name' => 'anna', 'post_id' => $post->id])
            ->assertOk();

        $this->actingAs($this->admin, 'admin')
            ->postJson(self::STORE_URI, ['name' => 'anna', 'post_id' => $post->id])
            ->assertOk();

        $this->assertDatabaseCount('keyword_post', 1);
    }

    public function testAddingKeywordClearsSearchCache(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        Cache::put(CacheKey::POSTS_SEARCH, ['cached'], 99999);

        $this->assertTrue(Cache::has(CacheKey::POSTS_SEARCH));

        $this->actingAs($this->admin, 'admin')
            ->postJson(self::STORE_URI, ['name' => 'barbara', 'post_id' => $post->id])
            ->assertOk();

        $this->assertFalse(Cache::has(CacheKey::POSTS_SEARCH));
    }

    public function testDeletingKeywordClearsSearchCache(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        /** @var Keyword $keyword */
        $keyword = Keyword::factory()->create(['name' => 'anna']);

        $post->keywords()->attach($keyword);

        Cache::put(CacheKey::POSTS_SEARCH, ['cached'], 99999);

        $this->assertTrue(Cache::has(CacheKey::POSTS_SEARCH));

        $this->actingAs($this->admin, 'admin')
            ->deleteJson(self::DELETE_URI, [
                'keyword_id' => $keyword->id,
                'post_id' => $post->id,
            ])
            ->assertOk();

        $this->assertFalse(Cache::has(CacheKey::POSTS_SEARCH));
    }

    public function testDeletingKeywordDeletesPostConnection(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();
        $keyword = Keyword::factory()->create(['name' => 'anna']);

        $post->keywords()->attach($keyword);

        $this->actingAs($this->admin, 'admin')
            ->deleteJson(self::DELETE_URI, [
                'keyword_id' => $keyword->id,
                'post_id' => $post->id,
            ])
            ->assertOk();

        $this->assertDatabaseEmpty('keyword_post');
    }

    public function testAfterDeletingKeywordConnectionKeywordIsNotDeleted(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();
        $keyword = Keyword::factory()->create(['name' => 'anna']);

        $this->actingAs($this->admin, 'admin')
            ->deleteJson(self::DELETE_URI, [
                'keyword_id' => $keyword->id,
                'post_id' => $post->id,
            ])
            ->assertOk();

        $this->assertDatabaseHas('keywords', [
            'id' => $keyword->id,
            'name' => $keyword->name,
        ]);
    }
}
