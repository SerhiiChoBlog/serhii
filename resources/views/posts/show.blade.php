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

        <div class="py-[5em] px-[1.5em] container">
            <div class="grid grid-cols-1 lg:grid-cols-2 relative">
                <div class="flex items-left justify-center flex-col">
                    <h1 style="font-size: {{ $title_font_size }}" class="leading-10 font-light">
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
                        class="absolute right-4 bottom-[-110px] w-[550px] rounded-lg shadow-md"
                    />
                </div>
            </div>
        </div>
    </section>

    <div class="container pb-6">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_25%]">
            <div>
                {{-- Chapters for mobile --}}
                <nav class="block lg:hidden">
                    <p class="panel-heading">
                        <span class="has-text-grey-dark">Chapters</span>
                    </p>
                    <chapters />
                </nav>

                <div class="prose max-w-none px-6 pt-10 text-xl"
                     id="post-content"
                     v-pre
                >{!! $post['content'] !!}</div>

                <div class="subtitle has-text-centered mt-6 is-flex is-flex-direction-column">
                    <span>Thanks for your time!</span>
                    <span>Please, share this post to support <a href="{{ route('about-me') }}">the author</a></span>
                </div>

                <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
            </div>

            <div>
                {{-- Post sidebar --}}
                <div class="post__sidebar">
                    <nav class="panel is-shadowless social-links--sidebar" style="min-height: 83px">
                        <p class="panel-heading">
                            <span class="has-text-grey-dark">Share this post</span>
                        </p>
                        <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
                    </nav>

                    <nav class="panel is-shadowless post__sidebar__chapters">
                        <p class="panel-heading">
                            <span class="has-text-grey-dark">Chapters</span>
                        </p>
                        <chapters />
                    </nav>

                    <nav class="panel-posts">
                        <p class="panel-heading">
                            <span class="has-text-grey-dark">Other posts</span>
                        </p>

                        @foreach ($posts as $other_post)
                            <a href="{{ route('posts.show', $other_post) }}" class="panel-posts__post">
                                <img data-src="{{ asset($other_post->image_sm) }}"
                                    alt="{{ $other_post->title }}"
                                    class="smooth-loader"
                                >
                                <h4 class="panel-posts__post__title">{{ $other_post->title }}</h4>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
