@php
    /**
     * @var App\Models\Subscription $subscription
     */
@endphp

@extends('layouts.main')

@push('title', 'Subscribed to Serhii Cho')
@push('description', "Your subscription has been confirmed and you've been added to the list")

@section('content')
    <x-hero class="bg-linear-to-r from-gray-700 to-gray-600 text-white" />

    <div class="container py-10 lg:py-48 px-5 flex flex-col lg:flex-row gap-14 items-center">
        <div>
            <img
                src="{{ asset('img/subscription/letter.svg') }}"
                alt="Letter"
                width="200"
                height="115"
                class="w-32 md:w-44 lg:w-52"
            >
        </div>
        <div>
            <h1
                class="text-3xl lg:text-7xl font-black text-main inline-block"
                style="
                    background: -webkit-linear-gradient(45deg, #d074a2, #2a4b67);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                "
            >
                Subscribed
            </h1>

            <p class="text-xl"></p>
            <p class="text-xl">Your subscription has been confirmed, and you've been added to the list.</p>

            @if ($subscription->tags->isEmpty())
                <p class="text-xl">You'll receive a letter every time a new post is published. 🥳</p>
            @else
                <p class="text-xl">You'll receive a letter every time a new post is published with tags that you've chosen. 🥳</p>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 xl:grid-cols-3 mt-8">
                    @foreach ($subscription->tags as $tag)
                        <a
                            href="/posts?tag={{ $tag->name }}"
                            class="flex items-center gap-3 bg-page-second px-4 py-2 rounded-md shadow-lg transition-shadow hover:shadow-xl"
                        >
                            <img
                                src="{{ asset("img/tags/{$tag->name}.webp") }}"
                                alt="Logo of {{ $tag->name }}"
                                width="200"
                                height="200"
                                class="w-10 h-10 drop-shadow-md"
                            />
                            <span class="text-lg">{{ $tag->title }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
