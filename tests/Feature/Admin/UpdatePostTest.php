<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\Post;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testPostCanBeUpdated(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $data = [
            'title' => 'Cool title is here and it must be long',
            'intro' => 'Short, but very interesting intro for the post',
            'content' => null,
        ];

        $slug = $this->actingAs($user, 'admin')
            ->put("/admin/ajax/posts/{$post->id}", $data)
            ->content();

        $this->assertEquals(str($data['title'])->slug(), $slug);

        $post->refresh();

        $this->assertSame($data['title'], $post->title);
        $this->assertSame($data['intro'], $post->intro);
        $this->assertSame($slug, $post->slug);
    }
}
