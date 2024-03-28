@php
    use App\Models\Post;

    /**
     * @var Post $post
     * @var string $title_font_size
     */

    $series = $post->series->first();
    $post_title = $series ? "{$series->title}: {$post->title}" : $post->title;
@endphp

@extends('layouts.main')

@push('head')
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:creator" content="@SerhiiCho">
    <meta name="twitter:title" content="{{ $post_title }}">
    <meta name="twitter:description" content="{{ $post->intro }}">
    <meta name="twitter:image" content="{{ asset($post->image_lg) }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $post_title }}">
    <meta property="og:description" content="{{ $post->intro }}" />
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('posts.show', $post->slug) }}">
    <meta property="og:image" content="{{ asset($post->image_lg) }}">
    <meta property="og:image:width" content="1000">
    <meta property="og:image:height" content="500">
    <meta property="article:published_time" content="{{ $post->created_at }}">
    <meta property="article:modified_time" content="{{ $post->updated_at }}">

    @foreach ($post->tags as $tag)
        <meta property="article:tag" content="{{ $tag->name }}">
    @endforeach

    @foreach ($post->keywords as $keyword)
        <meta property="article:tag" content="{{ $keyword->name }}">
    @endforeach

    <script src="{{ asset('js/highlight.js') }}" defer></script>
@endpush

@push('title', $post_title)
@push('description', str($post->intro)->limit(147))

@section('content')
    <like-post-button :post="{{ $post }}"></like-post-button>
    <zoomed-image></zoomed-image>

    <article>
        <div
            class="bg-gradient-to-r from-[#0f0f0f] to-[#383838] text-white print:!bg-none print:text-black"
            @if ($series)
                style="background: linear-gradient(90deg, {{ $series->color_from }} 0%, {{ $series->color_to }} 100%)"
            @endif
        >
            <div class="min-h-[64px]">
                <navbar theme="{{ request()->cookie('theme', 'system') }}"></navbar>
            </div>

            <div class="py-[2rem] px-[1.5rem] lg:py-[6rem] lg:px-[1.5rem] container">
                <div class="grid grid-cols-1 lg:grid-cols-2 relative gap-5">
                    <div class="flex items-left justify-center flex-col text-[.7rem] lg:text-[1rem]">
                        <h1
                            style="font-size: {{ $title_font_size }}"
                            class="leading-[1] font-light text-center lg:text-left"
                        >
                            {{ $post_title }}
                        </h1>

                        <x-post.tags :tags="$post->tags" class="text-sm mt-5 !gap-3" />

                        <div class="mt-4">
                            <x-post.details :post="$post" />
                        </div>

                        <div class="mt-4">
                            @if ($series)
                                <a
                                    href="{{ route('series.show', $series->slug) }}"
                                    class="px-3 py-1 rounded-md shadow-md text-md text-white"
                                    style="background-color: {{ $series->color_to }}"
                                >
                                    {{ $series->title }}:
                                    Part {{ $series->pivot->part }} of {{ $series->posts_count }}
                                </a>
                            @endif

                            <x-edit-button
                                url="/admin/posts/{{ $post->id }}/edit"
                                class="ml-3"
                            />
                        </div>
                    </div>

                    <div>
                        <img
                            src="{{ asset($post->image_lg) }}"
                            alt="Post {{ $post_title }}"
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
                    <div class="post-content lg:prose-xl pr-2 lg:px-6"
                        id="post-content"
                        v-pre
                    >
                        {!! $post->content !!}

                        <small class="text-font-second opacity-90 inline-block leading-[1.5]">
                            Keywords: {{ $post->keywords->implode('name', ', ') }}
                        </small>
                    </div>

                    <lazy-loading>
                        <prev-next-post :post-id="{{ $post->id }}" />
                    </lazy-loading>

                    <x-post.footer :post="$post" />

                    <nav role="navigation" class="print:hidden">
                        <x-post.sidebar-title>You might be interested</x-post.sidebar-title>

                        <lazy-loading>
                            <related-posts :post-id="{{ $post->id }}"></related-posts>
                        </lazy-loading>
                    </nav>
                </div>

                <div class="spacey-y-0 lg:space-y-10 px-3 h-full max-w-[500px] mx-auto lg:max-w-[320px] pt-0 2xl:pt-20">
                    <div class="hidden lg:block">
                        <nav class="min-h-[83px]">
                            <x-post.sidebar-title>Share this post</x-post.sidebar-title>
                            <share-post-buttons
                                post-title="{{ $post_title }}"
                                :post-id="{{ $post->id }}"
                            />
                        </nav>
                    </div>

                    @if ($post->video)
                        <div class="mt-4">
                            <x-post.sidebar-title>Related video</x-post.sidebar-title>
                            <x-post.video :video="$post->video" />
                        </div>
                    @endif

                    <chapters slug="{{ $post->slug }}" />
                </div>
            </div>
        </div>
    </article>
@endsection
