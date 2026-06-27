@php
    use App\Models\Series;

    /**
     * @var Series $series
     */
@endphp

@extends('layouts.main')

@push('title', $series->title)
@push('description', $series->intro)

@section('content')
    <x-hero
        class="bg-gray-800 text-white"
        style="background: linear-gradient(90deg, {{ $series->color_from }} 0%, {{ $series->color_to }} 100%)"
    />

    <div class="container mt-5">
        <div class="grid grid-cols-1 lg:grid-cols-[5fr_2fr] xl:grid-cols-[7fr_2fr] lg:gap-6">
            <div>
                <img
                    src="{{ asset($series->image_lg) }}"
                    alt="{{ $series->title }}"
                    class="w-full rounded-lg"
                    width="1600"
                    height="400"
                >

                <div class="py-5 md:my-10 mx-0 md:mx-5">
                    <div class="space-y-1">
                        <h1 class="text-2xl lg:text-4xl">{{ $series->title }}</h1>

                        <h2 class="text-lg lg:text-2xl text-main">
                            {{ $series->intro }}
                        </h2>

                        <h3 class="text-lg lg:text-xl">
                            {{ $series->posts_count }} {{ str('article')->plural($series->posts_count) }}

                            <x-edit-button
                                url="/admin/series/{{ $series->id }}/edit"
                                class="ml-2"
                            />
                        </h3>

                        <h4>{{ $series->read_time }} min total read time</h4>
                    </div>

                    <div class="post-content border-t border-border mt-4 md:mt-6">
                        {!! $series->description !!}
                    </div>

                    <div class="text-md mt-5">
                        <span>Last updated:</span>
                        <time datetime="{{ $series->updated_at }}">
                            {{ $series->updated_at->format('F j, Y') }}
                        </time>
                    </div>
                </div>
            </div>

            <div class="pb-5">
                <x-series.posts :series="$series" />
            </div>
        </div>
    </div>
@endsection
