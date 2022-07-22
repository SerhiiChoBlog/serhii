@extends('layouts.admin')

@section('content')
    <div class="container">
        <x-admin.page-title>
            <div class="flex items-center justify-center gap-3">
                <span>Tags</span>

                <x-admin.button :href="route('admin.tags.create')">
                    <i class="fas fa-plus"></i>
                </x-admin.button>
            </div>
        </x-admin.page-title>

        <div class="mt-5">
            @empty($tags->all())
                <h2 class="text-center text-xl mt-6">There are not tags</h2>
            @else
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full">
                        <thead class="bg-gray-500 text-left">
                            <tr>
                                @foreach (['Slug', 'Posts', 'Color', 'Tag', ''] as $title)
                                    <th class="text-white p-3 font-light">{{ $title }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $tag)
                                <tr class="odd:bg-gray-50 border-b transition-colors hover:bg-gray-100">
                                    <td class="px-3 py-2">{{ $tag->name }}</td>
                                    <td class="px-3 py-2">{{ $tag->posts_count }}</td>
                                    <td class="px-3 py-2">
                                        <input
                                            type="text"
                                            value="{{ $tag->color }}"
                                            class="w-[80px] text-center rounded-md bg-gray-200"
                                        >
                                    </td>
                                    <td class="px-3 py-2">
                                        <a
                                            href="/posts?tag={{ $tag->name }}"
                                            class="py-[3px] inline-block font-white px-2 rounded-md text-white text-xs"
                                            style="background-color: {{ $tag->color }}"
                                        >
                                            {{ $tag->name }}
                                        </a>
                                    </td>
                                    <td class="px-3 py-2">
                                        <a href="{{ route('admin.tags.edit', $tag) }}"
                                            class="text-font-second inline-block text-xs transition-colors hover:text-main-dark p-1"
                                            title="Edit tag"
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
    </div>
@endsection
