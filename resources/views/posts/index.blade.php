@php
    use App\Models\Tag;
    use Illuminate\Pagination\LengthAwarePaginator;
    use App\Models\Post;

    /**
     * @var LengthAwarePaginator<Post> $posts
     * @var Post $post
     * @var Tag|null $tag
     */

    $title = $tag ? sprintf("Articles on %s topic", $tag->title) : 'Web blog';
@endphp

@extends('layouts.app')

@push('title', "$title | Serhii Cho")
@push('description', "Blog that helps you to become a better web developer and create beautiful, functional websites using the latest web technologies and best practices")

@section('content')
    <x-hero
        :title="$title"
        subtitle="Blog that helps you to become a better web developer and create beautiful,<br />functional websites using the latest web technologies and best practices"
        class="bg-gradient-to-r from-[#d074a2] to-[#2a4b67] text-white"
    />

    <div class="container">
        <div class="bg-page max-w-[1100px] mx-auto -translate-y-6 rounded-xl px-3 pt-3">
            <div class="min-h-[40px]">
                <filters :current-tag="{{ $tag ?? 'null' }}"></filters>
            </div>

            @if ($posts->isEmpty())
                <x-posts.no-posts/>
            @else
                <div class="flex flex-col gap-y-2">

                    @foreach ($posts as $post)
                        <x-posts.horizontal-post
                            :post="$post"
                            :lazy="$loop->index > 1"
                        />
                    @endforeach

                    <div class="my-6 mx-4">
                        {{ $posts->appends(request()->input())->links('vendor.pagination.default') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <subscription></subscription>
@endsection
