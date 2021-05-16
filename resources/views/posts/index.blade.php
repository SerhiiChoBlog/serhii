@extends('layouts.app')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="buttons mb-5">
        <a href="{{ route('posts.create') }}" class="button is-info">Create post</a>
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
                                <img src="{{ asset($post->image_sm) }}" width="300" style="border-radius:4px">
                            </a>
                        </td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->intro ?? '-' }}</td>
                        <td><a href="{{ route('posts.edit', $post) }}" class="button is-small is-info">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endempty
</div>

@endsection
