@php
    use App\Models\Tag;
    use Illuminate\Pagination\LengthAwarePaginator;
    use App\Models\Post;

    /**
     * @var LengthAwarePaginator<Post> $posts
     * @var Post $post
     * @var Tag|null $tag
     */

    $title = $tag->title ?? 'Blog for web developers';
    $series = $posts->isEmpty() ? null : $posts->first()->series->first();
    $header_style = $series ? "background: linear-gradient(90deg, {$series->color_from} 0%, {$series->color_to} 100%)" : '';
@endphp

@extends('layouts.main')

@push('title', "{$title} | Serhii Cho")
@push('description', "You want to become a better web developer and create optimized, responsive and modern websites using the latest web technologies and best practices? Welcome!")

@section('content')
    <x-hero
        :mainTitle="$title"
        subtitle="You want to become a better web developer and create optimized, responsive<br>and modern websites using the latest web technologies and best practices? Welcome!"
        class="{{ $series ? '' : 'bg-home-hero' }} bg-cover text-white relative"
        :style="$header_style"
    >
        @if ($tag)
            <img
                src="{{ asset("/storage/tags/$tag->name.webp") }}"
                alt="The logo of {{ $tag->name }}"
                class="absolute top-1/2 left-1/4 -translate-y-1/2 opacity-50 w-[160px] h-[160px]"
                width="200"
                height="200"
            />
        @endif
    </x-hero>

    <div class="container">
        <div class="bg-page max-w-[1100px] mx-auto -translate-y-6 rounded-xl px-3 pt-3">
            <div class="min-h-[40px]">
                <filters :current-tag="{{ $tag ?? 'null' }}"></filters>
            </div>

            @if ($posts->isEmpty())
                <x-posts.no-posts/>
            @else
                <div class="flex flex-col gap-y-8 mt-4">

                    @foreach ($posts as $post)
                        <x-posts.horizontal-post :post="$post"/>
                    @endforeach

                    <div class="my-6 mx-4">
                        {{ $posts->appends(request()->input())->links('vendor.pagination.default') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
