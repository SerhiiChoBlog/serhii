@php
    /** @var \Illuminate\Support\Collection<\App\Models\Post> $posts */
@endphp

@extends('layouts.app')

@section('title', 'Blog for web developers')
@section('description', "I am mostly writing programming related articles on different topics. I am sharing my knowledge with others to help you become a better developer")

@section('content')
    <section class="hero blog-hero is-dark">
        <div class="hero-head">@include('includes.navbar')</div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">Blog for web developers</h1>
                <h2 class="subtitle">
                    I'm mostly writing programming related articles on different topics.<br>
                    I'm sharing my knowledge with others to help you become a better developer.
                </h2>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <div class="posts">
            @foreach ($posts as $post)
                <a href="/posts/{{ $post->slug }}" class="posts__item">
                    <img class="posts__item__image" src="{{ asset($post->image_sm) }}" alt="{{ $post->title }}" />

                    <div class="posts__item__content">
                        <h2 class="posts__item__content__title has-text-black">{{ $post->title }}</h2>
                        <p class="posts__item__content__intro">{{ $post->intro }}</p>
                        <div class="tags mt-2">
                            @foreach ($post->tags as $tag)
                                <span class="tag my-0 is-small is-normal is-dark" style="background-color: {{ $tag->color }}">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                            <time datetime="{{ $post->created_at }}" class="has-text-grey">{{ $post->pretty_created_at }}</time>
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
