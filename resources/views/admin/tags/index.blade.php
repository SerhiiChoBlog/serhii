@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_2fr] gap-x-6">
            <div class="border-b pb-7 mb-7 lg:border-none lg:pb-0 lg:mb-0">
                <div class="px-4">
                    <form action="{{ route('admin.tags.store') }}" method="POST">
                        @csrf

                        <div class="space-y-5">
                            <div>
                                <x-admin.input title="Name" name="name" type="text" placeholder="Enter the tag name" />
                            </div>

                            <div>
                                <x-admin.input title="Choose the color" name="color" type="color" />
                            </div>

                            <div>
                                <x-admin.button>
                                    <i class="fas fa-plus mr-2"></i> Create tag
                                </x-admin.button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                @empty($tags->all())
                    <h2 class="text-center text-xl mt-6">There are not tags</h2>
                @else
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full">
                            <thead class="bg-gray-500 text-left">
                                <tr>
                                    @foreach (['Name', 'Color', 'Tag', ''] as $title)
                                        <th class="text-white p-3 font-light">{{ $title }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tags as $tag)
                                    <tr class="odd:bg-gray-50 border-b transition-colors hover:bg-gray-100">
                                        <td class="px-3 py-2">{{ $tag->name }}</td>
                                        <td class="px-3 py-2">{{ $tag->color }}</td>
                                        <td class="px-3 py-2">
                                            <span class="py-[3px] inline-block font-light px-2 rounded-md text-white text-sm" style="background-color: {{ $tag->color }}">
                                                {{ $tag->name }}
                                            </span>
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
    </div>
@endsection
