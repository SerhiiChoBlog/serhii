<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Middleware;

use App\Models\Post;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CsrfProtectionTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const CSRF_TOKEN_MISMATCH_STATUS = 419;

    protected function setUp(): void
    {
        parent::setUp();

        // Laravel skips CSRF verification in tests, so use the real behaviour
        $this->app->bind(PreventRequestForgery::class, CsrfEnabledPreventRequestForgery::class);
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function providerForAdminWriteEndpointFailsWithoutCsrfToken(): array
    {
        return [
            'create post' => ['postJson', '/admin/ajax/posts'],
            'update post' => ['putJson', '/admin/ajax/posts/1'],
            'delete post' => ['deleteJson', '/admin/ajax/posts/1'],
            'upload post image' => ['postJson', '/admin/ajax/post-content-images/1'],
        ];
    }

    #[DataProvider('providerForAdminWriteEndpointFailsWithoutCsrfToken')]
    public function testAdminWriteEndpointFailsWithoutCsrfToken(string $method, string $uri): void
    {
        Post::factory()->create();

        $this->actingAs($this->createAdmin(), 'admin')
            ->{$method}($uri)
            ->assertStatus(self::CSRF_TOKEN_MISMATCH_STATUS);
    }

    public function testAdminMutationSucceedsWithCsrfToken(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $params = [
            'title' => $post->title,
            'intro' => 'This is a new intro for a post',
            'is_published' => false,
            'content' => 'This is some new content',
            'slug' => $post->slug,
        ];

        $this->actingAs($this->createAdmin(), 'admin')
            ->withSession(['_token' => 'test-token'])
            ->putJson("/admin/ajax/posts/{$post->id}", $params, ['X-CSRF-TOKEN' => 'test-token'])
            ->assertOk();

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'intro' => $params['intro']]);
    }
}

class CsrfEnabledPreventRequestForgery extends PreventRequestForgery
{
    protected function runningUnitTests(): bool
    {
        return false;
    }
}
