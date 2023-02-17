@php
    use App\Models\Post;

    /**
     * @var Post $post
     * @var string $title_font_size
     */
@endphp

@extends('layouts.main')

@push('head')
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:creator" content="@SerhiiCho">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ $post->intro }}">
    <meta name="twitter:image" content="{{ asset($post->image_lg) }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->intro }}" />
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('posts.show', $post->slug) }}">
    <meta property="og:image" content="{{ asset($post->image_lg) }}">
    <meta property="og:image:width" content="1000">
    <meta property="og:image:height" content="500">
    <meta property="article:published_time" content="{{ $post->created_at }}">
    <meta property="article:modified_time" content="{{ $post->updated_at }}">
    <meta property="article:publisher" content="https://www.facebook.com/serhii.cho.9/">

    @foreach ($post->tags as $tag)
        <meta property="article:tag" content="{{ $tag->name }}">
    @endforeach

    <script src="{{ asset('js/highlight.js') }}" defer></script>
@endpush

@push('title', $post->title)
@push('description', str($post->intro)->limit(147))

@section('content')
    <article>
        <div class="bg-gradient-to-r from-[#0f0f0f] to-[#383838] text-white print:bg-none print:text-black">
            <x-navbar />

            <div class="py-[2rem] px-[1.5rem] lg:py-[6rem] lg:px-[1.5rem] container">
                <div class="grid grid-cols-1 lg:grid-cols-2 relative">
                    <div class="flex items-left justify-center flex-col text-[.7rem] lg:text-[1rem] px-4">
                        <h1
                            style="font-size: {{ $title_font_size }}"
                            class="leading-[1] font-light text-center lg:text-left"
                        >
                            {{ $post->title }}
                        </h1>

                        <x-post.tags :tags="$post->tags" class="text-sm mt-5 !gap-3" />

                        <div class="flex items-center gap-2 mt-4">
                            <x-post.details :post="$post->toArray()" />

                            @if (isset($post['post_views_count']) && $post['post_views_count'] > 99)
                                <span aria-hidden="true" class="opacity-70">&#8226;</span>
                                <span class="opacity-70">{{ $post['post_views_count'] }} views</span>
                            @endif
                        </div>

                        @if (auth('admin')->check())
                            <div class="mt-4" aria-hidden="true">
                                <a
                                    href="/admin/posts/{{ $post->id }}/edit"
                                    class="px-5 border rounded-full border-dashed transition-opacity opacity-70 hover:opacity-100 py-1 uppercase text-xs"
                                >
                                    Edit
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <img
                            src="{{ asset($post->image_lg) }}"
                            alt="Post {{ $post->title }}"
                            width="1000"
                            height="500"
                            class="static mx-auto 2xl:absolute right-4 bottom-[-130px] w-[600px] xl:w-[700px] rounded-lg shadow-lg mt-7 lg:mt-0 z-10"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="container pb-6">
            <div class="grid w-full grid-cols-1 lg:grid-cols-[repeat(auto-fit,minmax(320px,auto))] gap-x-7 pt-10 print:pt-0 mx-auto max-w-[1230px] bg-page lg:-translate-y-8 lg:px-8 rounded-xl">
                <div>
                    @published ($post)
                        <div class="text-center mb-8 lg:hidden">
                            <x-download-pdf-button />
                        </div>

                        <div class="post-content lg:prose-xl pr-2 lg:px-6"
                            id="post-content"
                            v-pre
                        >
                            {!! $post->content !!}
                        </div>

                        <x-post.footer :post="$post" />
                    @else
                        <x-post.post-is-in-process />
                    @endpublished

                    <nav role="navigation" class="print:hidden">
                        <x-post.sidebar-title>You might be interested</x-post.sidebar-title>
                        <lazy-loading>
                            <related-posts :post-id="{{ $post->id }}"></related-posts>
                        </lazy-loading>
                    </nav>
                </div>

                @published ($post)
                    <div class="spacey-y-0 lg:space-y-10 px-3 h-full max-w-[500px] mx-auto lg:max-w-[320px] pt-0 2xl:pt-20">
                        <div class="hidden lg:block">
                            <nav class="min-h-[83px]">
                                <x-post.sidebar-title>Share this post</x-post.sidebar-title>
                                <share-post-buttons
                                    :is-auth="{{ auth()->check() ? 'true' : 'false' }}"
                                    post-title="{{ $post->title }}"
                                    :post-id="{{ $post->id }}"
                                />
                            </nav>
                        </div>

                        <div class="hidden lg:block">
                            <x-download-pdf-button />
                        </div>

                        @if ($post->video)
                            <div class="mt-4">
                                <x-post.sidebar-title>Related video</x-post.sidebar-title>
                                <x-post.video :video="$post->video" />
                            </div>
                        @endif

                        <chapters slug="{{ $post->slug }}" />
                    </div>
                @endpublished
            </div>
        </div>
    </article>
@endsection
