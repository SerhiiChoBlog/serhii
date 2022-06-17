@php
    use Illuminate\Pagination\LengthAwarePaginator;
    use App\Models\Post;

    /**
     * @var LengthAwarePaginator<Post> $posts
     * @var Post $post
     */
@endphp

@extends('layouts.app')

@section('title', 'Blog for web developers')
@section('description', "I am mostly writing programming related articles on different topics. I am sharing my knowledge with others to help you become a better developer")

@section('content')
    <x-hero title="Blog for web developers"
        subtitle="I'm mostly writing programming and productivity related articles.<br>Sharing my knowledge with others, learning and growing together."
        class="bg-gradient-to-r from-[#d074a2] to-[#2a4b67] text-white"
    />

    <div class="container mt-5">
        <div class="flex flex-col gap-y-2">

            @foreach ($posts as $post)
                <a href="/posts/{{ $post->slug }}"
                   class="flex flex-col lg:flex-row items-center gap-6 border-md p-3 rounded-xl transition-colors hover:bg-page-second max-w-[550px] lg:max-w-full mx-auto"
                >
                    <img src="{{ asset($post->image_sm) }}"
                        class="rounded-lg shadow-md shadow-[rgba(0,0,0,.2)] w-full max-w-max lg:max-w-[260px]"
                        alt="{{ $post->title }}"
                    />

                    <div class="font-lato">
                        <h2 class="text-xl text-font">{{ $post->title }}</h2>
                        <p class="pb-3 pt-1 text-lg mt-1 font-light text-font-second">{{ $post->intro }}</p>

                        <div>
                            <x-post.tags :tags="$post->tags" class="text-xs">
                                <x-post.created :created="$post->created_at" :pretty="$post->pretty_created_at" />
                            </x-post.tags>
                        </div>
                    </div>
                </a>
            @endforeach

            <div class="my-6 mx-4">
                {{ $posts->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>
@endsection
