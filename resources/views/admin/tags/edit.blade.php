@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="title">{{ $tag->name }}</h1>

                <div class="container">
                    <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input class="input" name="name" value="{{ $tag->name }}" type="text" placeholder="Enter the tag name">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Choose the color</label>
                            <div class="control">
                                <input class="input" value="{{ $tag->color }}" name="color" type="color">
                            </div>
                        </div>

                        <div class="field mt-4">
                            <button type="submit" class="button is-info">
                                <i class="fas fa-save mr-2"></i> Update
                            </button>
                            <button type="button" class="button is-danger ml-2" onclick="document.getElementById('delete-tag').click()">
                                <i class="fas fa-trash mr-2"></i> Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.tags.destroy', $tag) }}" method="post" class="is-hidden" onsubmit="return confirm('Sure you want to delete the tag?');">
            @csrf
            @method('delete')
            <button id="delete-tag" type="submit"></button>
        </form>
    </div>
@endsection
