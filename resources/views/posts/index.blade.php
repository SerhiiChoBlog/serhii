@php
    /** @var array[] $posts */
@endphp

@extends('layouts.app')

@section('content')
    <section class="hero blog-hero is-dark">
        <div class="hero-head">@include('includes.navbar')</div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">Blog</h1>
                <h2 class="subtitle">I'm mostly writing about productivity tips and technical related articles.</h2>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <div class="posts">
            @foreach ($posts as $post)
                <a href="/posts/{{ $post['slug'] }}" class="posts__item">
                    <img class="posts__item__image" src="{{ asset($post['image_sm']) }}" alt="{{ $post['title'] }}" />

                    <div class="posts__item__content">
                        <h2 class="posts__item__content__title has-text-black">{{ $post['title'] }}</h2>
                        <p class="posts__item__content__intro">{{ $post['intro'] }}</p>
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
