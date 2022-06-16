@php
    /** @var \App\Models\Post $post */
@endphp

@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/tinymce.js') }}"></script>
    <script>
        window.tinymce = tinymce
        tinymce.init({
            selector: '#content',
            plugins: 'codesample fullscreen code image link table lists paste',
            height: '800px',
            toolbar: 'undo redo | styleselect | bold italic | link image table | alignleft aligncenter alignright | numlist bullist | bullist numlist outdent indent | codesample code | fullscreen',
            image_caption: true,
            // paste_as_text: true,
            //skin: "oxide-dark",
            //content_css: "dark",
            codesample_languages: [
                {text: 'C#', value: 'csharp'},
                {text: 'Json', value: 'json'},
                {text: 'Nginx', value: 'nginx'},
                {text: 'SQL', value: 'sql'},
                {text: 'TypeScript', value: 'typescript'},
                {text: 'Apache', value: 'apache'},
                {text: 'C++', value: 'cpp'},
                {text: 'Go', value: 'go'},
                {text: 'Bash', value: 'bash'},
                {text: 'Java', value: 'java'},
                {text: 'Text', value: 'text'},
                {text: 'Ruby', value: 'ruby'},
                {text: 'CSS', value: 'css'},
                {text: 'HTML/XML', value: 'html'},
                {text: 'JavaScript', value: 'javascript'},
                {text: 'Makefile', value: 'makefile'},
                {text: 'PHP', value: 'php'},
                {text: 'Python', value: 'python'},
                {text: 'Yaml', value: 'yaml'},
                {text: 'C', value: 'c'},
                {text: 'Markdown', value: 'markdown'},
                {text: 'PHP Template', value: 'php-template'},
                {text: 'Scss', value: 'scss'},
            ],
            setup: function(editor) {
                editor.on('blur', function () {
                    window.dispatchEvent(new CustomEvent('savePost'))
                });
                editor.on('keydown', function (e) {
                    if ((e.ctrlKey || e.metaKey) && e.code === 'KeyS') {
                        e.preventDefault()
                        window.dispatchEvent(new CustomEvent('savePost'))
                    }
                });
            }
        })
    </script>
@endsection

@section('content')
    <div class="container pb-6">
        <h1 class="text-4xl text-font-second">{{ $post->title }}</h1>

        <div class="container">
            <form action="{{ route('admin.posts.update', $post) }}"
                method="post"
                enctype="multipart/form-data"
                id="edit-post-form"
            >
                @csrf
                @method('put')

                <input type="hidden" name="post-id" id="post-id-field" value="{{ $post->id }}">

                <div class="flex flex-col lg:flex-row gap-6 mt-10">
                    <div class="flex-1">
                        <div>
                            <x-admin.input
                                type="text"
                                name="title"
                                placeholder="Enter the title"
                                :value="$post->title"
                                :required="true"
                                maxlength="190"
                                class="_letter-counter"
                            >Title</x-admin.input>
                        </div>

                        <div class="mt-5">
                            <x-admin.input placeholder="Choose tags" type="text" id="post-tags" name="post-tags">
                                Tags
                                <div id="suggestions-target" class="ml-1 inline-block space-x-1"></div>
                            </x-admin.input>
                            <ul class="bg-white shadow-md mt-2 rounded-lg overflow-hidden hidden" id="post-tags-popup"></ul>
                        </div>

                        <div class="field mt-5">
                            <x-admin.input
                                :textarea="true"
                                placeholder="Enter a short intro"
                                name="intro"
                                class="_letter-counter min-h-[100px]"
                                :value="$post->intro"
                                maxlength="190"
                            >
                            </x-admin.input>
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="relative">
                            <img src="{{ asset($post->image_sm ?? 'storage/posts/placeholder.jpg') }}"
                                alt="image"
                                id="post-image"
                                class="rounded-md shadow-lg w-full"
                            />
                            <label for="post-image-input"
                                class="opacity-0 flex items-center hover:opacity-100 transition-opacity border-[6px] border-dashed text-center rounded-lg cursor-pointer border-gray-300 absolute right-6 top-6 left-6 bottom-6"
                            >
                                <b class="text-gray-600 px-4 py-2 rounded-xl bg-gray-300 text-3xl drop-shadow-sm mx-auto shadow-lg opacity-90">Choose image</b>
                            </label>
                            <input type="file" id="post-image-input" name="image" class="hidden">
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <textarea name="content" id="content">{{ $post->content }}</textarea>
                </div>

                <div>
                    <div class="flex flex-col justify-center fixed right-[20px] top-[70px] z-[9999] space-y-2">
                        <x-admin.button type="submit" class="bg-green-500 hover:bg-green-600">
                            <i class="fas fa-save mr-2"></i> Save
                        </x-admin.button>
                        <x-admin.button
                            href="{{ route('posts.show', $post) }}"
                            target="_blank"
                            id="preview-the-post"
                        >
                            <i class="fas fa-eye mr-2"></i> Preview
                        </x-admin.button>
                    </div>

                    <div class="buttons">
                        <button
                            type="button"
                            class="button is-danger"
                            onclick="document.getElementById('delete-post').click()"
                        >
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                        <label class="checkbox">
                            <input type="checkbox"
                                name="is-published"
                                class="ml-3 mr-1" {{ $post->is_published ? 'checked' : '' }}
                            />
                            <span>publish this post</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-6 pt-4">
            <h3 class="subtitle has-text-centered mb-5">Attached images for this post</h3>

            <table class="table is-fullwidth is-hoverable is-striped mb-6">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>URI</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($post->images as $image)
                        <tr>
                            <td>
                                <a href="{{ $image->uri }}" target="_blank">
                                    <img data-src="{{ asset($image->uri) }}"
                                        alt="Post image"
                                        width="100"
                                        class="smooth-loader"
                                        style="border-radius: 4px"
                                    />
                                </a>
                            </td>
                            <td><input type="text" value="{{ $image->uri }}" class="clean-input" disabled></td>
                            <td>
                                <form action="{{ route('admin.post-content-images.delete', $image) }}"
                                    method="post"
                                    onsubmit="return confirm('Sure you want to delete this content image?')"
                                >
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="button is-danger">
                                        <i class="fas fa-trash mr-2"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="{{ route('admin.post-content-images.store', $post) }}"
                  method="post"
                  enctype="multipart/form-data"
            >
                @csrf
                <div class="file is-inline-block mr-2">
                    <label class="file-label">
                        <input class="file-input" type="file" name="image" required>
                        <span class="file-cta"><span class="file-label">Choose an image...</span></span>
                    </label>
                </div>
                <button class="button is-success" type="submit">
                    <i class="fas fa-upload mr-2"></i> Load
                </button>
            </form>
        </div>
    </div>

    <input type="hidden" value="{{ $post->tags }}" id="old-post-tags">

    <form action="{{ route('admin.posts.destroy', $post) }}" method="post" class="is-hidden" onsubmit="return confirm('Sure you want to delete the post?')">
        @csrf
        @method('delete')
        <button type="submit" id="delete-post"></button>
    </form>
@endsection
