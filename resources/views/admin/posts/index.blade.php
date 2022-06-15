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
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="table-auto">
                    <thead class="bg-gray-600 text-white">
                        <tr>
                            <th></th>
                            <th class="p-3">Image</th>
                            <th class="p-3 min-w-[300px]">Title</th>
                            <th class="p-3">Intro</th>
                            <th class="p-3">Shares</th>
                            <th class="p-3">Views</th>
                            <th class="p-3">View</th>
                            <th class="p-3">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr class="bg-white even:bg-gray-50 nth border-b">
                                <td class="p-3">
                                    @if ($post->is_published)
                                        <i class="fas fa-check text-green-600"></i>
                                    @else
                                        <i class="fas fa-times text-red-600"></i>
                                    @endif
                                </td>
                                <td class="p-1">
                                    <a href="{{ asset($post->image_lg) }}" target="_blank">
                                        <img src="{{ asset($post->image_sm) }}"
                                            width="300"
                                            class="rounded-md shadow-md"
                                            alt="{{ $post->title }}"
                                        />
                                    </a>
                                </td>
                                <td class="p-3 text-xl leading-6">{{ $post->title }}</td>
                                <td class="p-3 text-sm">{{ $post->intro ?? '-' }}</td>
                                <td class="p-3 text-center">{{ $post->social_shares_count }}</td>
                                <td class="p-3 text-center">{{ $post->page_views_count }}</td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('posts.show', $post) }}"
                                       class="text-sm border rounded-sm w-10 h-10 flex justify-center items-center transition-colors hover:bg-gray-100"
                                       title="View post"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('admin.posts.edit', $post) }}"
                                       class="text-sm border rounded-sm w-10 h-10 flex justify-center items-center transition-colors hover:bg-gray-100"
                                       title="Edit post"
                                    >
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
