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
    <script src="{{ asset('js/highlight.js') }}" defer></script>
@endsection

@section('title', $post['title'])
@section('description', $post['intro'])

@section('content')
    <section class="bg-gradient-to-r from-[#0f0f0f] to-[#383838] text-white">
        <x-navbar />

        <div class="py-[2rem] px-[1.5rem] lg:py-[5rem] lg:px-[1.5rem] container">
            <div class="grid grid-cols-1 lg:grid-cols-2 relative">
                <div class="flex items-left justify-center flex-col text-[.7rem] lg:text-[1rem]">
                    <h1 style="font-size: {{ $title_font_size }}" class="leading-10 font-light text-center lg:text-left">
                        {{ $post['title'] }}
                    </h1>

                    <x-post.tags :tags="$post['tags']" class="text-sm mt-5">
                        <div class="opacity-70 flex items-center">
                            <time datetime="{{ $post['created_at'] }}" class="ml-2">
                                {{ $post['pretty_created_at'] }}
                            </time>

                            @if ($post['page_views_count'] >= 100)
                                <span class="flex items-center gap-x-2 ml-3">
                                    <img src="{{ asset('storage/icons/light-eye.png') }}" alt="eye icon" width="22">
                                    <span>{{ $post['page_views_count'] }}</span>
                                </span>
                            @endif
                        </div>

                        @if (auth()->check())
                            <a href="{{ route('admin.posts.edit', ['post' => $post['id']]) }}"
                               class="flex items-center px-5 ml-2 border rounded-full border-dashed transition-opacity opacity-70 hover:opacity-100"
                            >
                                Edit post
                            </a>
                        @endif
                    </x-post.tags>
                </div>

                <div>
                    <img src="{{ asset($post['image_lg']) }}"
                        alt="{{ $post['title'] }}"
                        class="static lg:absolute right-4 bottom-[-110px] w-[550px] rounded-lg shadow-md mt-7 lg:mt-0"
                    />
                </div>
            </div>
        </div>
    </section>

    <div class="container pb-6">
        <div class="grid grid-cols-1 lg:grid-cols-[75%_25%]">
            <div>
                {{-- Chapters for mobile --}}
                <nav class="block lg:hidden mt-16">
                    <x-post.sidebar-title>Chapters</x-post.sidebar-title>
                    <chapters />
                </nav>

                {{-- Blog post content --}}
                <div class="prose-lg lg:prose-xl max-w-none px-2 lg:px-6 pt-8 lg:pt-16 font-lato"
                     id="post-content"
                     v-pre
                >{!! $post['content'] !!}</div>

                {{-- End of the post --}}
                <div class="subtitle has-text-centered mt-6 is-flex is-flex-direction-column">
                    <span>Thanks for your time!</span>
                    <span>Please, share this post to support <a href="{{ route('about-me') }}">the author</a></span>
                </div>

                <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
            </div>

            {{-- Post sidebar --}}
            <div class="pt-16">
                <nav class="min-h-[83px] mb-7">
                    <x-post.sidebar-title>Share this post</x-post.sidebar-title>
                    <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
                </nav>

                <nav class="mb-7">
                    <x-post.sidebar-title>Chapters</x-post.sidebar-title>
                    <chapters />
                </nav>

                <nav class="mb-7">
                    <x-post.sidebar-title>Other posts</x-post.sidebar-title>

                    <div class="flex flex-col gap-y-2">
                        @foreach ($posts as $other_post)
                            <a href="{{ route('posts.show', $other_post) }}" class="p-2 transition-opacity hover:opacity-80">
                                <img data-src="{{ asset($other_post->image_sm) }}"
                                    alt="{{ $other_post->title }}"
                                    class="smooth-loader rounded-lg shadow-lg"
                                >
                                <h4 class="text-lg leading-6 my-3">{{ $other_post->title }}</h4>
                            </a>
                        @endforeach
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection
