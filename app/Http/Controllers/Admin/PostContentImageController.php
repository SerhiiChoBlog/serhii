<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostContentImage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostContentImageController extends Controller
{
    public function store(Post $post, Request $request): void
    {
        /** @var UploadedFile $image */
        $image = $request->file('image');

        $path = storage_path('app/public/posts/content');

        $slug = Str::slug($post->title);

        $image_name = sprintf("%s-%s.%s", $slug, time(), $image->getClientOriginalExtension());

        Image::make($image)->save("$path/$image_name");

        $post->images()->create([
            'uri' => "/storage/posts/content/$image_name",
            'path' => "/public/posts/content/$image_name",
        ]);
    }

    public function destroy(PostContentImage $image): void
    {
        Storage::delete($image->path);
        $image->delete();
    }
}
