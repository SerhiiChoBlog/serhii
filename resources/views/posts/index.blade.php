@php
    use App\Models\Tag;
    use Illuminate\Pagination\LengthAwarePaginator;
    use App\Models\Post;

    /**
     * @var LengthAwarePaginator<Post> $posts
     * @var Post $post
     * @var Tag|null $tag
     */

    $title = $tag ? sprintf("Articles on %s topic", $tag->title) : 'Web blog';
@endphp

@extends('layouts.app')

@push('title', "$title | Serhii Cho")
@push('description', "Blog that helps you to become a better web developer and create beautiful, functional websites using the latest web technologies and best practices")

@section('content')
    <x-hero
        :title="$title"
        subtitle="Blog that helps you to become a better web developer and create beautiful,<br />functional websites using the latest web technologies and best practices"
        class="bg-gradient-to-r from-[#d074a2] to-[#2a4b67] text-white"
    />

    <div class="container">
        <div class="bg-page max-w-[1100px] mx-auto -translate-y-6 rounded-xl px-3 pt-3">
            <div class="min-h-[40px]">
                <filters :current-tag="{{ $tag ?? 'null' }}"></filters>
            </div>

            @if ($posts->isEmpty())
                <x-posts.no-posts/>
            @else
                <div class="flex flex-col gap-y-2">

                    @foreach ($posts as $post)
                        <article>
                            <div
                                class="flex flex-col lg:flex-row items-center gap-6 border-md p-3 rounded-xl max-w-[550px] lg:max-w-full mx-auto transition-colors hover:bg-page-second">
                                <a href="/posts/{{ $post->slug }}" class="block w-full max-w-max lg:max-w-[300px]">
                                    <img
                                        @if ($loop->index === 0)
                                            src="{{ asset($post->image_sm) }}"
                                        @else
                                            data-src="{{ asset($post->image_sm) }}"
                                        @endif
                                        class="rounded-lg shadow-md shadow-[rgba(0,0,0,.2)] w-full"
                                        width="550"
                                        height="275"
                                        alt="Main image for the post '{{ $post->title }}'"
                                    />
                                </a>

                                <div>
                                    <a href="/posts/{{ $post->slug }}">
                                        <h2 class="text-2xl text-font">{{ $post->title }}</h2>
                                        <p class="mt-2 text-lg font-light text-font-second font-post">{{ $post->intro }}</p>
                                    </a>

                                    <div>
                                        <x-post.tags :tags="$post->tags" class="text-[.8em] mt-3"/>
                                        <x-post.details :post="$post->toArray()" class="mt-3"/>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach

                    <div class="my-6 mx-4">
                        {{ $posts->appends(request()->input())->links('vendor.pagination.default') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
