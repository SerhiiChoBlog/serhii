<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostContentImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostContentImageController extends Controller
{
    public function store(Post $post, Request $request): RedirectResponse
    {
        $image = $request->file('image');

        $path = storage_path('app/public/posts/content');

        $incrementer = $post->images()->count() + 1;
        $slug = Str::slug($post->title);

        $image_name = "$slug-$incrementer.{$image->getClientOriginalExtension()}";

        Image::make($image)->save("$path/$image_name");

        $post->images()->create([
            'alt' => $post->title,
            'uri' => "/storage/posts/content/$image_name",
            'path' => "/public/posts/content/$image_name",
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    public function destroy(PostContentImage $image): RedirectResponse
    {
        Storage::delete($image->path);
        $image->delete();
        return back();
    }
}
