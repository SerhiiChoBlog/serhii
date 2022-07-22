@php
    use Illuminate\Pagination\LengthAwarePaginator;
    use App\Models\Post;

    /**
     * @var LengthAwarePaginator<Post> $posts
     * @var Post $post
     */
@endphp

@extends('layouts.app')

@section('title', 'Blog for web developers')
@section('description', "I'm writing articles about programming, productivity and happiness in general. I'm writing everything that can potentially benefit me and increase my productivity.")

@section('content')
    <x-hero title="Blog for web developers"
        subtitle="I'm writing articles about programming, productivity and happiness in general.<br>I'm writing everything that can potentially benefit me and increase my productivity."
        class="bg-gradient-to-r from-[#d074a2] to-[#2a4b67] text-white"
    />

    <div class="container">
        @if ($posts->isEmpty())
            @if (request()->has('tag'))
                <h2 class="text-center text-xl mt-10">
                    There are no posts with the tag
                    <strong class="text-font-second">"{{ request('tag') }}"</strong>
                </h2>
            @else
                <h2 class="text-center text-xl mt-10">
                    There are no posts found
                </h2>
            @endif

            <div class="flex gap-3 justify-center mt-5">
                @foreach (['/' => 'Go home', '/posts' => 'All posts'] as $url => $title)
                    <a href="{{ $url }}" class="px-10 py-2 border border-border rounded-full uppercase">
                        {{ $title }}
                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col gap-y-2 max-w-[1100px] mx-auto -translate-y-6 bg-page rounded-xl px-3 pt-3">

                @foreach ($posts as $post)
                    <article>
                        <div class="flex flex-col lg:flex-row items-center gap-6 border-md p-3 rounded-xl max-w-[550px] lg:max-w-full mx-auto transition-colors hover:bg-page-second">
                            <a href="/posts/{{ $post->slug }}" class="block w-full max-w-max lg:max-w-[260px]">
                                <img
                                    data-src="{{ asset($post->image_sm) }}"
                                    class="rounded-lg shadow-[rgba(0,0,0,.2)] w-full"
                                    width="260"
                                    height="141"
                                    alt="{{ $post->title }}"
                                />
                            </a>

                            <div>
                                <a href="/posts/{{ $post->slug }}">
                                    <h2 class="text-2xl text-font">{{ $post->title }}</h2>
                                    <p class="mt-2 text-lg font-light text-font-second font-post">{{ $post->intro }}</p>
                                </a>

                                <div>
                                    <x-post.tags :tags="$post->tags" class="text-[.8em] mt-3" />
                                    <x-post.details :post="$post->toArray()" class="mt-3" />
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach

                <div class="my-6 mx-4">
                    {{ $posts->links('vendor.pagination.default') }}
                </div>
            </div>
        @endif
    </div>
@endsection
