<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostContentImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class PostContentImageController extends Controller
{
    public function store(Post $post, Request $request): string
    {
        $post->load('series:id,slug');

        /** @var UploadedFile|null $image */
        $image = $request->file('image');

        if (!$image) {
            return '';
        }

        $slug = $this->getImageSlug($post);
        $path = storage_path('app/public/posts/content');
        $original_name = $image->getClientOriginalName();

        if (str_starts_with($original_name, $slug)) {
            $image_name = $original_name;
        } else {
            $image_name = sprintf("%s-%s.%s", $slug, time(), $image->getClientOriginalExtension());
        }

        $image->move($path, $image_name);

        $post->images()->create([
            'uri' => "/storage/posts/content/{$image_name}",
            'path' => "/public/posts/content/{$image_name}",
        ]);

        $post->touch();

        return url("/storage/posts/content/{$image_name}");
    }

    public function export(Post $post): Response
    {
        $post->load('images');

        $paths = $post->images->map(function (PostContentImage $image) {
            return storage_path('/app' . $image->path);
        });

        $zip_path = public_path('post-images.zip');
        $zip = new ZipArchive();

        if (file_exists($zip_path)) {
            unlink($zip_path);
        }

        if (!$zip->open($zip_path, ZipArchive::CREATE)) {
            return response('', 500);
        }

        foreach ($paths as $path) {
            $file_name = basename($path);

            try {
                $zip->addFile($path, $file_name);
            } catch (Exception $e) {
                return response("File {$path} cannot be added. Exception: {$e->getMessage()}", 500);
            }
        }

        $zip->close();

        return response($zip_path);
    }

    public function destroy(PostContentImage $image): void
    {
        Storage::delete($image->path);
        $image->delete();
    }

    private function getImageSlug(Post $post): string
    {
        $series = $post->series->first();
        $post_slug = Str::slug($post->title);

        return $series ? "{$series->slug}-{$post_slug}" : $post_slug;
    }
}
