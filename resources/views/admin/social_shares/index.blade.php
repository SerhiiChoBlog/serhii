@php
    /** @var App\Models\Post[] $posts */
@endphp

@extends('layouts.admin')

@section('content')
    <div class="container">
        @empty($posts->all())
            <h2 class="subtitle has-text-centered">There are not posts</h2>
        @else
            @foreach ($posts as $post)
                <article class="message">
                    <div class="message-header">
                        <p>{{ $post->title }}</p>
                    </div>
                    <div class="message-body is-flex is-align-items-center is-justify-content-center">
                        @foreach ($post->social as $social => $items)
                            <div class="tags has-addons mb-0 mr-4">
                                <span class="tag is-white is-medium" style="border: 1px solid #3298dc">
                                    <img src="{{ asset("storage/icons/$social.png") }}" alt="{{ $social }}" width="27">
                                    <span class="ml-2">{{ ucfirst($social) }}</span>
                                </span>
                                <span class="tag is-info is-medium">{{ count($items) }}</span>
                            </div>
                        @endforeach
                    </div>
                </article>
            @endforeach
        @endempty
    </div>
@endsection
