@php
    use App\Models\Tag;
    use Illuminate\Pagination\LengthAwarePaginator;
    use App\Models\Post;
    use App\Models\Series;

    /**
     * @var LengthAwarePaginator<Post> $posts
     * @var Post $post
     * @var Tag|null $tag
     * @var Series|null $series
     */

    $title = $tag ? "Read about {$tag->title}" : 'Articles for developers';
    $header_style = $series ? "background: linear-gradient(90deg, {$series->color_from} 0%, {$series->color_to} 100%)" : '';
@endphp

@extends('layouts.main')

@push('title', $title)
@push('description', "Writing about software development, systems, and the practical details that make things work")

@section('content')
    <x-hero
        :mainTitle="$title"
        subtitle="Writing about software development,<br>systems, and the practical details that make things work."
        class="{{ $series ? '' : 'home-hero' }} bg-cover text-white relative"
        :style="$header_style"
    >
        @if ($tag)
            <img
                src="{{ asset("img/tags/$tag->name.webp") }}"
                alt="The logo of {{ $tag->name }}"
                class="absolute top-1/2 left-1/4 -translate-y-1/2 opacity-50 w-40 h-40"
                width="200"
                height="200"
            />
        @endif
    </x-hero>

    <div class="container">
        <div class="bg-page max-w-[1100px] mx-auto -translate-y-6 rounded-xl px-3 pt-3">
            <div class="min-h-10">
                <filters :current-tag="{{ $tag ?? 'null' }}"></filters>
            </div>

            @if ($posts->isEmpty())
                <x-posts.no-posts/>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-6 mt-4">
                    @foreach ($posts as $post)
                        <x-posts.horizontal-post :post="$post"/>
                    @endforeach
                </div>

                <div class="my-6 mx-4">
                    {{ $posts->appends(request()->input())->links('vendor.pagination.default') }}
                </div>
            @endif
        </div>
    </div>
@endsection
