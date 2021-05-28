@php
    /** @var App\Models\Post[] $posts */
@endphp

@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="buttons mb-5">
            <a href="{{ route('admin.posts.create') }}" class="button is-info">
                <i class="fas fa-plus mr-2"></i> Create post
            </a>
        </div>

        @empty($posts->all())
            <h2 class="subtitle has-text-centered">There are not posts</h2>
        @else
            <table class="table is-fullwidth">
                <thead>
                <tr>
                    <th>Image</th>
                    <th style="min-width:300px">Title</th>
                    <th>Intro</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                    <tr style="background-color: {{ $post->is_published ? '#00ff000d' : '#ff00000d' }}">
                        <td>
                            <a href="{{ asset($post->image_lg) }}" target="_blank">
                                <img src="{{ asset($post->image_sm) }}" width="300" style="border-radius:4px" alt="{{ $post->title }}" />
                            </a>
                        </td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->intro ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="icon has-text-grey-dark" title="Edit post">
                                <i class="fas fa-pen"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endempty
    </div>
@endsection
