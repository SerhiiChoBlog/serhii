@php
    /** @var App\Models\Post[] $posts */
@endphp

@extends('layouts.admin')

@section('content')
    <div class="container">
        <x-admin.page-title>Visitors</x-admin.page-title>

        <div>
            @empty($posts->all())
                <h2 class="text-2xl text-center">There are not posts</h2>
            @else
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full">
                        <thead class="bg-gray-500 text-left">
                            <tr>
                                @foreach (['Article', '', '', '', ''] as $title)
                                    <th class="text-white p-3 font-light">{{ $title }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr class="odd:bg-gray-50 border-b transition-colors hover:bg-gray-100">
                                    <td class="p-2">{{ $post->title }}</td>

                                    @foreach ($post->social as $social => $items)
                                        <td class="p-1">
                                            <div class="flex flex-col lg:flex-row gap-x-2 items-center">
                                                <img src="{{ asset("storage/icons/$social.png") }}"
                                                     alt="{{ $social }}"
                                                     width="20"
                                                />

                                                <span class="text-md font-bold text-font-second">
                                                    {{ count($items) }}
                                                </span>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endempty
        </div>
    </div>
@endsection
