@php
    /** @var array $post */
    /** @var string $title_font_size */
@endphp

@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/highlight.js') }}"></script>
@endsection

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

                <div class="subtitle has-text-centered mt-6">Share this post</div>
                @include('includes.share-post', compact('post'))
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
                        @include('includes.share-post', compact('post'))
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
