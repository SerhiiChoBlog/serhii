<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostContentImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostContentImageController extends Controller
{
    public function store(Post $post, Request $request): RedirectResponse
    {
        $image = $request->file('image');

        $path = storage_path($storage_path = 'app/public/posts/content');

        $incrementer = $post->images()->count() + 1;
        $slug = Str::slug($post->title);

        $image_name = "$slug-$incrementer.{$image->getClientOriginalExtension()}";

        Image::make($image)->save("$path/$image_name");

        $post->images()->create([
            'alt' => $post->title,
            'uri' => "/storage/posts/content/$image_name",
            'path' => "$storage_path/$image_name",
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    public function destroy(Post $post, PostContentImage $image): RedirectResponse
    {
        // todo: delete file
        $image->delete();

        return redirect()->route('admin.posts.edit', $post);
    }
}
