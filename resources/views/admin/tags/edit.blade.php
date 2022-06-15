@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-5xl text-center drop-shadow-xl text-main-dark mb-5">
                {{ $tag->name }}
            </h1>

            <div class="container">
                <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
                    @csrf
                    @method('put')

                    <div class="space-y-5">
                        <x-admin.input title="Name"
                            name="name"
                            type="text"
                            placehoder="Enter the tag name"
                            :value="old('name', $tag->name)"
                        />

                        <x-admin.input title="Choose the color"
                            :value="old('color', $tag->color)"
                            name="color"
                            type="color"
                        />

                        <div class="flex gap-x-3 justify-center">
                            <x-admin.button>
                                <i class="fas fa-save mr-2"></i> Update
                            </x-admin.button>

                            <x-admin.button type="button"
                                onclick="document.getElementById('delete-tag').click()"
                                class="bg-red-600 hover:bg-red-700"
                            >
                                <i class="fas fa-trash mr-2"></i> Delete
                            </x-admin.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <form action="{{ route('admin.tags.destroy', $tag) }}"
            method="post"
            class="hidden"
            onsubmit="return confirm('Sure you want to delete the tag?');"
        >
            @csrf
            @method('delete')
            <button id="delete-tag" type="submit"></button>
        </form>
    </div>
@endsection
