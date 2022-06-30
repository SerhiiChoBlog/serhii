@extends('layouts.app')

@section('content')
    <x-hero
        title="SERHII<span class='text-main-light'>CHO</span>"
        subtitle="<typewriter />"
        class="bg-gradient-to-r from-[#163249] via-[#657ca1] to-[#657ca1] text-white"
    />

    <section class="py-8 lg:py-14 px-4">
        <div class="container">
            <div>
                <x-home.section-title>Nice to meet you</x-home.section-title>

                <p class="px-0 lg:px-8 text-lg lg:text-xl font-light leading-7 lg:leading-9">
                    <x-home.welcome-section />

                    <a
                        href="{{ route('about-me') }}"
                        class="text-link hover:text-link-hover hover:underline transition-colors"
                    >
                        Read mode about me...
                    </a>
                </p>
            </div>
        </div>
    </section>

    <section class="py-12 bg-page-second">
        <div class="container">
            <x-home.last-posts-section />
        </div>
    </section>
@endsection
