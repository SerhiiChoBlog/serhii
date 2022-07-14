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

    <div class="container mt-5">
        <div class="flex flex-col gap-y-2 max-w-[1100px] mx-auto">

            @foreach ($posts as $post)
                <article>
                    <a
                        href="/posts/{{ $post->slug }}"
                        class="flex flex-col lg:flex-row items-center gap-6 border-md p-3 rounded-xl transition-colors hover:bg-page-second max-w-[550px] lg:max-w-full mx-auto"
                        aria-label="{{ $post->title }}"
                    >
                        <img
                            src="{{ asset($post->image_sm) }}"
                            class="rounded-lg shadow-md shadow-[rgba(0,0,0,.2)] w-full max-w-max lg:max-w-[260px]"
                            alt="{{ $post->title }}"
                        />

                        <div>
                            <h2 class="text-2xl text-font">{{ $post->title }}</h2>
                            <p class="mt-2 text-lg font-light text-font-second">{{ $post->intro }}</p>

                            <div>
                                <x-post.tags :tags="$post->tags" class="text-[.8em] mt-2" />
                                <x-post.details :post="$post->toArray()" class="mt-2" />
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach

            <div class="my-6 mx-4">
                {{ $posts->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>
@endsection
