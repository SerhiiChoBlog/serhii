@php
    /** @var array $post */
    /** @var App\Models\Post[] $posts */
    /** @var string $title_font_size */
@endphp

@extends('layouts.app')

@section('head')
    <meta name="twitter:card" content="summary">
    <meta name="twitter:creator" content="@SerhiiCho">
    <meta name="twitter:title" content="{{ $post['title'] }}">
    <meta name="twitter:description" content="{{ $post['intro'] }}">
    <meta name="twitter:image" content="{{ asset($post['image_lg']) }}">
    <meta property="og:title" name="title" content="{{ $post['title'] }}">
    <meta property="og:description" content="{{ $post['intro'] }}" />
    <meta property="og:image" content="{{ asset($post['image_lg']) }}">
    <meta property="og:type" content="article">
    <meta property="og:image:width" content="1000">
    <meta property="og:image:height" content="545">
    <meta property="article:published_time" content="{{ $post['created_at'] }}">
    <meta property="article:modified_time" content="{{ $post['updated_at'] }}">
    <meta property="article:publisher" content="https://www.facebook.com/serhii.cho.9/">

    @foreach ($post['tags'] as $tag)
        <meta property="article:tag" content="{{ $tag['name'] }}">
    @endforeach

    <script src="{{ asset('js/highlight.js') }}" defer></script>
@endsection

@section('title', $post['title'])
@section('description', $post['intro'])

@section('content')
    <section class="bg-gradient-to-r from-[#0f0f0f] to-[#383838] text-white">
        <x-navbar />

        <div class="py-[2rem] px-[1.5rem] lg:py-[6rem] lg:px-[1.5rem] container">
            <div class="grid grid-cols-1 lg:grid-cols-2 relative">
                <div class="flex items-left justify-center flex-col text-[.7rem] lg:text-[1rem] px-4">
                    <h1
                        style="font-size: {{ $title_font_size }}"
                        class="leading-[1] font-light text-center lg:text-left"
                    >
                        {{ $post['title'] }}
                    </h1>

                    <x-post.tags :tags="$post['tags']" class="text-sm mt-5">
                        <div class="opacity-70 flex items-center">
                            <time datetime="{{ $post['created_at'] }}" class="ml-2">
                                {{ $post['pretty_created_at'] }}
                            </time>

                            @if ($post['page_views_count'] >= 100)
                                <span class="flex items-center gap-x-2 ml-3">
                                    <img
                                        src="{{ asset('storage/icons/light-eye.png') }}"
                                        alt="eye icon"
                                        width="22"
                                        height="22"
                                    />

                                    <span>{{ $post['page_views_count'] }}</span>
                                </span>
                            @endif
                        </div>

                        @if (auth()->check())
                            <a
                               href="{{ route('admin.posts.edit', ['post' => $post['id']]) }}"
                               class="flex items-center px-5 ml-2 border rounded-full border-dashed transition-opacity opacity-70 hover:opacity-100 py-1 uppercase text-xs"
                            >
                                Edit post
                            </a>
                        @endif
                    </x-post.tags>
                </div>

                <div>
                    <img
                        src="{{ asset($post['image_lg']) }}"
                        alt="{{ $post['title'] }}"
                        width="1000"
                        height="545"
                        class="static mx-auto 2xl:absolute right-4 bottom-[-130px] w-[600px] rounded-lg shadow-lg mt-7 lg:mt-0"
                    />
                </div>
            </div>
        </div>
    </section>

    <div class="container pb-6">
        <div class="grid w-full grid-cols-1 lg:grid-cols-[repeat(auto-fit,minmax(320px,auto))] gap-x-7 pt-8 lg:pt-20 mx-auto max-w-[1200px]">
            <div>
                <div class="post-content lg:prose-xl pr-2 lg:px-6"
                    id="post-content"
                    v-pre
                >{!! $post['content'] !!}</div>

                <x-post.footer :post="$post" />

                {{-- Other posts --}}
                <nav>
                    <x-post.sidebar-title>Other posts</x-post.sidebar-title>

                    <div class="flex flex-col md:flex-row gap-2">
                        @foreach ($posts as $other_post)
                            <a href="{{ route('posts.show', $other_post) }}"
                               class="p-2 transition-opacity hover:opacity-80 min-h-[160px]"
                            >
                                <img data-src="{{ asset($other_post->image_sm) }}"
                                    alt="{{ $other_post->title }}"
                                    class="rounded-lg shadow-lg"
                                    width="550"
                                    height="300"
                                />
                                <h4 class="text-lg leading-6 my-3">{{ $other_post->title }}</h4>
                            </a>
                        @endforeach
                    </div>
                </nav>
            </div>

            <div class="spacey-y-0 lg:space-y-12 px-3 h-full max-w-[320px]">
                <div class="hidden lg:block">
                    <nav class="min-h-[83px]">
                        <x-post.sidebar-title>Share this post</x-post.sidebar-title>
                        <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
                    </nav>
                </div>

                <chapters slug="{{ $post['slug'] }}" />
            </div>
        </div>
    </div>
@endsection
