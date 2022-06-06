@php
    /** @var array $post */
    /** @var \App\Models\Post[] $posts */
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
    <section class="hero post-hero is-dark">
        <div class="hero-head">@include('includes.navbar')</div>

        <div class="hero-body">
            <div class="container">
                <div class="columns">
                    <div class="column is-flex is-align-items-left is-justify-content-center is-flex-direction-column">
                        <h1 class="title" style="font-size: {{ $title_font_size }}">
                            {{ $post['title'] }}
                        </h1>

                        <div class="tags mt-2">
                            @foreach ($post['tags'] as $tag)
                                <span class="tag my-0 is-medium is-normal is-dark"
                                      style="background-color: {{ $tag['color'] }}"
                                >{{ $tag['name'] }}</span>
                            @endforeach

                            <time datetime="{{ $post['created_at'] }}" class="post__created-at ml-2">{{ $post['pretty_created_at'] }}</time>

                            @if ($post['page_views_count'] >= 100)
                                <span class="post__views ml-3">
                                    <img src="{{ asset('storage/icons/light-eye.png') }}" alt="eye icon" width="22">
                                    <span>{{ $post['page_views_count'] }}</span>
                                </span>
                            @endif

                            @if (auth()->check())
                                <a href="{{ route('admin.posts.edit', ['post' => $post['id']]) }}" class="post__edit">
                                    Edit post
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="column">
                        <img src="{{ asset($post['image_lg']) }}" alt="{{ $post['title'] }}" class="post-hero__image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container pb-6 post">
        <div class="row">
            <div class="col-lg-9">
                <nav class="panel is-shadowless post__chapters">
                    <p class="panel-heading">
                        <span class="has-text-grey-dark">Chapters</span>
                    </p>
                    <chapters />
                </nav>

                <div class="content post__content px-3" id="post-content" v-pre>{!! $post['content'] !!}</div>

                <div class="subtitle has-text-centered mt-6 is-flex is-flex-direction-column">
                    <span>Thanks for your time!</span>
                    <span>Please, share this post to support <a href="{{ route('about-me') }}">the author</a></span>
                </div>

                <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
            </div>
            <div class="col-lg-3">
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
