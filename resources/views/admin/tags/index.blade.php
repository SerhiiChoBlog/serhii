@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="grid grid-cols-[1fr_2fr] gap-x-6">
            <div>
                <div class="px-4">
                    <form action="{{ route('admin.tags.store') }}" method="POST">
                        @csrf

                        <div class="space-y-5">
                            <x-admin.input title="Name" name="name" type="text" placeholder="Enter the tag name" />
                            <x-admin.input title="Choose the color" name="color" type="color" />
                            <x-admin.button>
                                <i class="fas fa-plus mr-2"></i> Create tag
                            </x-admin.button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                @empty($tags->all())
                    <h2 class="subtitle has-text-centered">There are not tags</h2>
                @else
                    <table class="table is-fullwidth is-hoverable is-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Color</th>
                                <th>Tag</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $tag)
                                <tr>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->color }}</td>
                                    <td>
                                        <span class="tag is-normal is-dark" style="background-color: {{ $tag->color }}">
                                            {{ $tag->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.tags.edit', $tag) }}" class="icon has-text-grey-dark" title="Edit tag">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endempty
            </div>
        </div>
    </div>
@endsection
