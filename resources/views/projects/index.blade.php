@php
    /** @var array[] $projects */
@endphp

@extends('layouts.main')

@push('title', 'Open-source projects | {S} Serhii')
@push('description', "Serhii Cho is a maintainer of several open-source libraries which you can contribute to any of them on GitHub")

@section('content')
    <x-hero
        mainTitle="Open-source"
        subtitle="I'm the maintainer of several open-source libraries and browser extension.<br>You can contribute to any of them on GitHub, and I would gladly look into your pull request or issue."
        class="bg-gradient-to-r from-[#51895c] via-[#4c5f7d] to-[#51895c] text-white"
    />

    <div class="container my-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 -translate-y-12 bg-page rounded-xl px-5 pt-5">

            @foreach ($projects as $project)
                <article>
                    <a
                        href="{{ $project['has_homepage'] ? $project['url'] : "/projects/{$project['name']}" }}"
                        class="bg-page-second p-7 h-full rounded-md shadow-md hover:shadow-lg transition-shadow relative flex flex-col justify-center min-h-[320px]"
                        title="Go to a project"
                        {{ $project['has_homepage'] ? 'target="_blank"' : '' }}
                    >
                        <img
                            src="{{ asset(sprintf('/storage/languages/%s.webp', strtolower($project['language']))) }}"
                            alt="{{ $project['title'] }}"
                            class="absolute right-4 top-4 w-12 aspect-square"
                            width="80"
                            height="80"
                        />

                        <div>
                            <h2 class="first-letter:text-main font-bold text-2xl text-font uppercase">
                                {{ $project['title'] }}
                            </h2>

                            <p class="text-lg mt-3 text-font-second border-t border-t-border pt-3 pb-6">
                                {{ $project['description'] }}

                                <small class="text-font-second opacity-70 block mt-1">
                                    Last commit {{ $project['pretty_updated_at'] }}
                                </small>
                            </p>

                            <div class="absolute bottom-3 inset-x-6 flex justify-between items-center text-md text-gray-500">
                                <div class="flex items-center gap-1">
                                    @if ($project['has_homepage'])
                                        <x-icons.external class="w-4 h-4"/>
                                        <small>external link</small>
                                    @endif
                                </div>

                                <div class="flex items-center">
                                    <x-icons.star class="w-4 h-4 gap-0.5" />
                                    <small>{{ $project['stars'] }}</small>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach

        </div>
    </div>
@endsection
