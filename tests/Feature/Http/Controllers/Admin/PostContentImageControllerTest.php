<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostContentImage;
use App\Models\Tag;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostContentImageControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testImportImagesAttachesThemToPost(): void
    {
        /** @var Collection<int, Tag> $tags */
        $tags = Tag::factory(3)->create();

        /** @var Post $post */
        $post = Post::factory()->create();

        $admin = $this->createAdmin();
        $zip_path = base_path('tests/files/post-files.zip');

        // Move zip file to a temporary directory to keep the original
        // zip file untouched
        $tmp_zip_path = sys_get_temp_dir() . '/post-files.zip';

        copy($zip_path, $tmp_zip_path);

        $file = new UploadedFile(
            path: $tmp_zip_path,
            originalName: 'post-files.zip',
            mimeType: 'application/zip',
            test: true,
        );

        $uri = "/admin/ajax/post-content-images/{$post->id}/import";

        $resp = $this->actingAs($admin, 'admin')
            ->postJson($uri, compact('file'))
            ->assertSuccessful()
            ->assertContent('Images are imported!');

        $this->assertFileExists($zip_path);
        $this->assertFileDoesNotExist(storage_path('temp.zip'));
        $this->assertCount(3, $post->images);

        // Remove copied post images
        $post->images->each(function (PostContentImage $image) {
            Storage::delete($image->path);
            $image->delete();
        });
    }
}
