@php
    /** @var array[] $posts */
@endphp

@extends('layouts.app')

@section('content')

<section class="hero blog-hero is-dark">
    <div class="hero-head">@include('includes.navbar')</div>

    <div class="hero-body">
        <div class="container has-text-centered">
            <p class="title">Blog</p>
            <p class="subtitle">I'm mostly writing about productivity tips and technical related articles.</p>
        </div>
    </div>
</section>

<div class="container mt-5">
    <div v-else class="posts">
        @foreach ($posts as $post)
            <a href="/posts/{{ $post['slug'] }}" class="post">
                <img class="post-image" src="{{ asset($post['image_sm']) }}" alt="{{ $post['title'] }}" />

                <div class="post-content">
                    <h2 class="post-title has-text-black">{{ $post['title'] }}</h2>
                    <p class="post-intro">{{ $post['intro'] }}</p>
                    <div class="tags mt-2">
                        @foreach ($post['tags'] as $tag)
                            <span class="tag my-0 is-small is-normal is-dark" style="background-color: {{ $tag['color'] }}">
                                {{ $tag['name'] }}
                            </span>
                        @endforeach
                        <span class="has-text-grey">{{ $post['pretty_created_at'] }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>

@endsection
