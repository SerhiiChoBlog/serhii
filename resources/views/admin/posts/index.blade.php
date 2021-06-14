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
            <div class="table-container">
                <table class="table is-fullwidth is-bordered">
                    <thead>
                    <tr>
                        <th>Published</th>
                        <th>Image</th>
                        <th style="min-width:300px">Title</th>
                        <th>Intro</th>
                        <th>Shares</th>
                        <th>Views</th>
                        <th>View</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>
                                @if ($post->is_published)
                                    <i class="fas fa-check has-text-success"></i>
                                @else
                                    <i class="fas fa-times has-text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <a href="{{ asset($post->image_lg) }}" target="_blank">
                                    <img src="{{ asset($post->image_sm) }}" width="300" style="border-radius:4px" alt="{{ $post->title }}" />
                                </a>
                            </td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->intro ?? '-' }}</td>
                            <td>{{ $post->social_shares_count }}</td>
                            <td>{{ $post->page_views_count }}</td>
                            <td>
                                <a href="{{ route('posts.show', $post) }}" class="button is-small" title="View post">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="button is-small" title="Edit post">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endempty
    </div>
@endsection
