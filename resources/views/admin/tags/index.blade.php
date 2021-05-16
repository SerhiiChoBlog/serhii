@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="columns">
        <div class="column">
            <div class="px-4">
                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf

                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input class="input" name="name" type="text" placeholder="Enter the tag name">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Choose the color</label>
                        <div class="control">
                            <input class="input" name="color" type="color">
                        </div>
                    </div>

                    <div class="field mt-4">
                        <button type="submit" class="button is-info">Create</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="column is-three-fifths">
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
                                <td><a href="{{ route('admin.tags.edit', $tag) }}" class="button is-small">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endempty
        </div>
    </div>
</div>

@endsection
