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
                        <p class="title" style="font-size: {{ $title_font_size }}">
                            {{ $post['title'] }}
                        </p>
                        <div class="tags mt-2">
                            @foreach ($post['tags'] as $tag)
                                <span class="tag my-0 is-medium is-normal is-dark"
                                      style="background-color: {{ $tag['color'] }}"
                                >{{ $tag['name'] }}</span>
                            @endforeach
                            <span class="created-at ml-2">{{ $post['pretty_created_at'] }}</span>
                        </div>
                    </div>
                    <div class="column">
                        <img src="{{ asset($post['image_lg']) }}" alt="{{ $post['title'] }}" class="post-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container pb-6 post">
        <div class="row">
            <div class="col-lg-9">
                <div class="content post-content px-3" v-pre>{!! $post['content'] !!}</div>

                <div class="subtitle has-text-centered mt-6">Share this post</div>
                <div class="social-links">
                    <a href="https://www.reddit.com/submit?url={{ url()->current() }}&title={{ $post['title'] }}" target="_blank" rel="nofollow noopener noreferrer">
                        <img src="{{ asset('storage/icons/reddit.png') }}" alt="reddit">
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank" rel="nofollow noopener noreferrer">
                        <img src="{{ asset('storage/icons/linkedin.png') }}" alt="linked in">
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ $post['title'] }}&url={{ url()->current() }}" target="_blank" rel="nofollow noopener noreferrer">
                        <img src="{{ asset('storage/icons/twitter.png') }}" alt="twitter">
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" rel="nofollow noopener noreferrer">
                        <img src="{{ asset('storage/icons/facebook.png') }}" alt="facebook">
                    </a>
                </div>
            </div>
            <div class="col-lg-3"><PostSidebar /></div>
        </div>
    </div>
@endsection
