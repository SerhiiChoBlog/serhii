@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/tinymce.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'codesample fullscreen code',
            height: '500px',
            toolbar: 'undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright | bullist numlist outdent indent | codesample fullscreen',
            codesample_languages: [
                {text: 'HTML/XML', value: 'html'},
                {text: 'JavaScript', value: 'javascript'},
                {text: 'CSS', value: 'css'},
                {text: 'PHP', value: 'php'},
                {text: 'Ruby', value: 'ruby'},
                {text: 'Python', value: 'python'},
                {text: 'Java', value: 'java'},
                {text: 'C', value: 'c'},
                {text: 'C#', value: 'csharp'},
                {text: 'C++', value: 'cpp'}
            ],
        })
    </script>
@endsection

@section('content')
    <div class="container">
        <h1 class="title">{{ $post->title }}</h1>

        <div class="container">
            <form action="{{ route('admin.posts.update', $post) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label for="title" class="label">Title</label>
                            <div class="control has-icons-right">
                                <input value="{{ $post->title }}"
                                    class="input letter-counter"
                                    id="title"
                                    type="text"
                                    name="title"
                                    placeholder="Enter the title"
                                    maxlength="190"
                                    required
                                >
                                <span class="icon is-small is-right counter"></span>
                            </div>
                        </div>

                        <div class="field mt-5">
                            <label for="post-tags" class="label">
                                <span class="mr-2">Tags</span>
                                <b id="suggestions-target"></b>
                            </label>
                            <div class="control post-tags">
                                <input class="input"
                                    id="post-tags"
                                    type="text"
                                    placeholder="Choose tags"
                                >
                                <ul class="post-tags__popup is-hidden" id="post-tags-popup"></ul>
                            </div>
                        </div>

                        <div class="field mt-5">
                            <label for="intro" class="label">Intro</label>
                            <div class="control has-icons-right">
                                <textarea class="input letter-counter"
                                    id="intro"
                                    name="intro"
                                    placeholder="Enter a short intro"
                                    maxlength="190"
                                    style="min-height:95px"
                                    required
                                >{{ $post->intro }}</textarea>
                                <span class="icon is-small is-right counter"></span>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="image-wrapper">
                            <img src="{{ asset($post->image_sm ?? 'storage/posts/placeholder.jpg') }}" alt="image" id="post-image">
                            <label for="post-image-input"><b>Choose image</b></label>
                            <input type="file" id="post-image-input" name="image" class="is-hidden">
                        </div>
                    </div>
                </div>

                <div class="field mt-5">
                    <textarea name="content" id="content">{{ $post->content }}</textarea>
                </div>

                <div class="field">
                    <div class="buttons">
                        <button type="submit" class="button px-6 is-success">Update</button>
                        <a href="https://serhii.io/draft/{{ $post->slug }}" target="_blank" class="button is-info">Preview</a>
                        <button type="button" class="button" onclick="document.getElementById('delete-post').click()">Delete</button>

                        <label class="checkbox">
                            <input type="checkbox" name="is-published" class="ml-3 mr-1" {{ $post->is_published ? 'checked' : '' }}>
                            <span>publish this post</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-6">
        </div>
    </div>

    <input type="hidden" value="{{ $post->tags }}" id="old-post-tags">

    <form action="{{ route('admin.posts.destroy', $post) }}" method="post" class="is-hidden" onsubmit="return confirm('Sure you want to delete the post?');">
        @csrf
        @method('delete')
        <button type="submit" id="delete-post"></button>
    </form>
@endsection
