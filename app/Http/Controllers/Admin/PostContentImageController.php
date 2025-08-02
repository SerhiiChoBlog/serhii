<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostContentImage;
use Exception;
use Illuminate\Http\File;
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
        $post->createImage($image_name);
        $post->touch();

        return url("/storage/posts/content/{$image_name}");
    }

    public function import(Post $post, Request $request): Response
    {
        $request->validate(['file' => ['required', 'extensions:zip']]);

        /** @var UploadedFile */
        $zip_file = $request->file;
        $zip = new ZipArchive();

        $zip_file->move(storage_path(), 'temp.zip');
        $local_zip_path = storage_path('temp.zip');
        $zip->open($local_zip_path);

        try {
            $temp_dir_path = $this->createTempDir();
            $zip->extractTo($temp_dir_path);

            $this->attachFilesToPost($post, $temp_dir_path);
        } catch (Exception $e) {
            return response("Error: {$e->getMessage()}");
        }

        $zip->close();

        unlink($local_zip_path);
        rmdir($temp_dir_path);

        return response('Images are imported!');
    }

    public function export(Post $post): Response
    {
        $post->load('images');

        $paths = $post->images->map(function (PostContentImage $image) {
            return storage_path('/app' . $image->path);
        });

        $zip_name = 'post-images.zip';
        $zip_path = public_path($zip_name);
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

        return response(url($zip_name));
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

    private function createTempDir(): string
    {
        $path = storage_path(sprintf("temp-%s", time()));

        if (file_exists($path)) {
            throw new Exception("Directory already exists: {$path}");
        }

        $is_created = mkdir($path, 0755, true);

        if (!$is_created) {
            throw new Exception("Failed to create temporary directory: {$path}");
        }

        return $path;
    }

    private function attachFilesToPost(Post $post, string $temp_dir_path): void
    {
        $destination = storage_path('app/public/posts/content');
        $file_names = array_filter(scandir($temp_dir_path), function (string $name) {
            return !in_array($name, ['..', '.', '.gitkeep'], true);
        });

        foreach ($file_names as $name) {
            $move_from = "{$temp_dir_path}/{$name}";
            $move_to = "{$destination}/{$name}";

            if (file_exists($move_to)) {
                unlink($move_to);
            }

            rename($move_from, $move_to);

            $post->createImage($name);
        }
    }
}
