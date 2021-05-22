@php
    /** @var array $post */
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
    <script src="{{ asset('js/highlight.js') }}"></script>
@endsection

@section('title', $post['title'])

@section('content')
    <section class="hero post-hero is-dark">
        <div class="hero-head">@include('includes.navbar')</div>

        <div class="hero-body">
            <div class="container">
                <div class="columns">
                    <div class="column is-flex is-align-items-left is-flex-direction-column">
                        <h1 class="title" style="font-size: {{ $title_font_size }}">
                            {{ $post['title'] }}
                        </h1>
                        <div class="tags mt-2">
                            @foreach ($post['tags'] as $tag)
                                <span class="tag my-0 is-medium is-normal is-dark"
                                      style="background-color: {{ $tag['color'] }}"
                                >{{ $tag['name'] }}</span>
                            @endforeach
                            <span class="post__created-at ml-2">{{ $post['pretty_created_at'] }}</span>
                            <span class="post__views ml-3">
                                <img src="{{ asset('storage/icons/light-eye.png') }}" alt="eye icon" width="22">
                                <span>{{ $post['page_views_count'] }}</span>
                            </span>
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
                <div class="content post__content px-3" v-pre>{!! $post['content'] !!}</div>

                <div class="subtitle has-text-centered mt-6">
                    Thanks for your time! Share this post
                </div>
                <div class="spinner"></div>
                <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
            </div>
            <div class="col-lg-3">
                <div class="post__sidebar">
                    <nav class="panel is-shadowless">
                        <p class="panel-heading">
                            <span class="has-text-grey-dark">Open source projects</span>
                        </p>
                        @foreach ($projects as $project)
                            <a href="{{ route('projects.show', $project['name']) }}" class="panel-block">{{ $project['title'] }}</a>
                        @endforeach
                    </nav>

                    <nav class="panel is-shadowless social-links--sidebar">
                        <p class="panel-heading">
                            <span class="has-text-grey-dark">Share this post</span>
                        </p>
                        <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
