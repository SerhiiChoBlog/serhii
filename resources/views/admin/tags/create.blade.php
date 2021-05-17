@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="title">Basic information</h1>
        <h2 class="subtitle">Enter title, tags and short intro for future blog post.</h2>

        <form action="{{ route('admin.posts.store') }}" method="post">
            @csrf

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <div class="control">
                            <input class="input" id="title" type="text" name="title" placeholder="Enter the title" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <button type="submit" class="button px-6 is-info">Create</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
