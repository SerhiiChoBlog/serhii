@php
    use App\Models\Series;

    /**
     * @var Series $series
     */
@endphp

@extends('layouts.main')

@push('title', " | Serhii Cho")
@push('description', '')

@section('content')
    <div style="background: linear-gradient(90deg, {{ $series->color_from }} 0%, {{ $series->color_to }} 100%)">
        <x-hero
            class="bg-gray-800 text-white"
            style="background: transparent"
        />

        <div class="container text-white">
            <div class="grid grid-cols-1 lg:grid-cols-[5fr_2fr] xl:grid-cols-[7fr_2fr] lg:gap-6">
                <div>
                    <img
                        src="{{ asset($series->image_lg) }}"
                        alt="{{ $series->title }}"
                        class="w-full rounded-lg"
                        width="1600"
                        height="400"
                    >

                    <h1 class="text-2xl lg:text-4xl mt-4">{{ $series->title }} series</h1>

                    <h2 class="text-xl lg:text-2xl text-main-light">
                        {{ $series->intro }}
                    </h2>

                    <h3 class="text-lg lg:text-xl text-gray-300">
                        {{ $series->posts_count }} {{ str('article')->plural($series->posts_count) }}
                    </h3>

                    <p class="text-md lg:text-lg border-t border-gray-500 pt-5 mt-5">
                        {!! nl2br($series->description) !!}
                    </p>

                    <div class="text-gray-300 text-md mt-5 pb-5 lg:pb-10">
                        <span>Last updated:</span>
                        <time datetime="{{ $series->updated_at }}">
                            {{ $series->updated_at->format('F j, Y') }}
                        </time>
                    </div>
                </div>

                <div class="pb-5">
                    <x-series.posts :series="$series" />
                </div>
            </div>
        </div>
    </div>
@endsection
