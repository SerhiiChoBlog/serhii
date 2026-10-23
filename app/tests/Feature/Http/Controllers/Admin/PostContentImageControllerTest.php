<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostContentImage;
use App\Models\Tag;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use ZipArchive;

class PostContentImageControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testImportImagesAttachesThemToPost(): void
    {
        Tag::factory(3)->create();

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

        $this->actingAs($admin, 'admin')
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

    public function testStoreUsesExtensionFromMimeTypeInsteadOfClientFilename(): void
    {
        Tag::factory(3)->create();

        /** @var Post $post */
        $post = Post::factory()->create();
        $admin = $this->createAdmin();

        $file = $this->imageWithClientName("{$post->slug}.txt");

        $response = $this->actingAs($admin, 'admin')
            ->postJson("/admin/ajax/post-content-images/{$post->id}", ['image' => $file])
            ->assertSuccessful();

        $this->assertStringEndsWith('.jpg', $response->getContent());

        /** @var PostContentImage $image */
        $image = $post->images()->firstOrFail();

        $this->assertStringEndsWith('.jpg', $image->uri);
        $this->assertFileExists(storage_path("app{$image->path}"));

        Storage::delete($image->path);
    }

    public function testStoreRejectsImageWithPhpClientExtension(): void
    {
        Tag::factory(3)->create();

        /** @var Post $post */
        $post = Post::factory()->create();
        $admin = $this->createAdmin();

        $file = $this->imageWithClientName("{$post->slug}.php");

        $this->actingAs($admin, 'admin')
            ->postJson("/admin/ajax/post-content-images/{$post->id}", ['image' => $file])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('image');

        $this->assertCount(0, $post->images);
    }

    public function testStoreRejectsNonImageUpload(): void
    {
        Tag::factory(3)->create();

        /** @var Post $post */
        $post = Post::factory()->create();
        $admin = $this->createAdmin();

        $file = UploadedFile::fake()->create('evil.php', 10, 'application/x-php');

        $this->actingAs($admin, 'admin')
            ->postJson("/admin/ajax/post-content-images/{$post->id}", ['image' => $file])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('image');

        $this->assertCount(0, $post->images);
    }

    public function testImportOnlyAttachesImageFiles(): void
    {
        Tag::factory(3)->create();

        /** @var Post $post */
        $post = Post::factory()->create();
        $admin = $this->createAdmin();

        $zip_path = sys_get_temp_dir() . '/' . uniqid('post-files-', true) . '.zip';
        $good_image = UploadedFile::fake()->image('good-image.jpg');

        $zip = new ZipArchive();
        $zip->open($zip_path, ZipArchive::CREATE);
        $zip->addFromString('good-image.jpg', (string) file_get_contents($good_image->getPathname()));
        $zip->addFromString('evil.php', '<?php echo "pwned";');
        $zip->close();

        $file = new UploadedFile(
            path: $zip_path,
            originalName: 'post-files.zip',
            mimeType: 'application/zip',
            test: true,
        );

        $this->actingAs($admin, 'admin')
            ->postJson("/admin/ajax/post-content-images/{$post->id}/import", compact('file'))
            ->assertSuccessful()
            ->assertContent('Images are imported!');

        $content_path = storage_path('app/public/posts/content');

        $this->assertCount(1, $post->images);
        $this->assertSame('good-image.jpg', basename($post->images->first()->uri));
        $this->assertFileExists("{$content_path}/good-image.jpg");
        $this->assertFileDoesNotExist("{$content_path}/evil.php");

        @unlink("{$content_path}/good-image.jpg");
        @unlink($zip_path);
    }

    private function imageWithClientName(string $client_name): UploadedFile
    {
        $path = sys_get_temp_dir() . '/' . uniqid('image-', true) . '.jpg';

        // Keep the fake file alive until its content is copied, otherwise the
        // underlying tmpfile resource is closed and the file is removed.
        $fake = UploadedFile::fake()->image('image.jpg');

        file_put_contents($path, (string) file_get_contents($fake->getPathname()));

        return new UploadedFile(
            path: $path,
            originalName: $client_name,
            mimeType: 'image/jpeg',
            test: true,
        );
    }
}
