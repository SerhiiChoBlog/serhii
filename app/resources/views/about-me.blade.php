@extends('layouts.main')

@push('title', 'Information about Serhii Cho')
@push('description', 'Just another hacker summoning bugs while dabbling in all kinds of tech sorcery. I sprinkle open-source magic everywhere, and live inside Linux terminal')

@section('content')
    <x-hero
        mainTitle="Serhii Cho"
        subtitle="Just another hacker summoning bugs while dabbling in all kinds of tech sorcery.<br>I sprinkle open-source magic everywhere, and live inside Linux terminal."
        class="bg-linear-to-r from-[#657ca1] via-[#445a7e] to-[#163249] text-white"
    />

    <div class="mt-2 text-xl">
        <section class="text-[1.2rem] px-2 lg:px-6 py-8">
            <div class="container">
                <div class="bg-page -translate-y-16 rounded-xl pt-8">
                    <div class="grid grid-cols-1 gap-x-6 lg:grid-cols-[25%_1fr]">
                        <div class="w-[180px] mx-auto rounded-lg top-36 mb-6">
                            <img
                                src="/img/serhii-cho.webp"
                                alt="Serhii Cho"
                                class="my-auto rounded-lg mx-auto transition-all duration-500 shadow-md pointer-events-none select-none"
                                width="180"
                                height="180"
                            />
                        </div>

                        <div class="about-me prose-xl prose-h2:mb-6 prose-h2:mt-0">
                            <p>
                                I've started programming {{ $diff }} ago and spent 5 years working at a company based in the Netherlands.
                                After that, I worked as a contractor on various projects.
                            </p>

                            <p>
                                Today I mostly work on developer tools. This includes a templating engine for Go called
                                <a href="https://textwire.github.io/" target="_blank">Textwire</a>,
                                libraries for Go, PHP, and TypeScript, editor and browser extensions, and
                                tooling around LSP and Tree-sitter. All of this work is open source and lives on
                                <a href="https://github.com/SerhiiCho" target="_blank">GitHub</a>.
                            </p>

                            <p>
                                Sometimes I post coding videos on
                                <a href="https://www.youtube.com/@serhiicho" target="_blank">YouTube</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative bg-page-second py-10 px-5 min-h-125">
            <div class="container pt-8 lg:pt-16">
                <x-section-detail />

                <div class="grid grid-cols-1 lg:grid-cols-3 print:grid-cols-2 gap-7">
                    @foreach (config('technologies.technologies') as $tech)
                        <div class="max-w-[420px] mx-auto">
                            <div>
                                <figure>
                                    <img
                                        data-src="{{ asset($tech['image']) }}"
                                        alt="{{ $tech['title'] }}"
                                        class="w-auto h-[130px] print:h-auto print:max-w-[50px] mx-auto drop-shadow-md pointer-events-none select-none"
                                        width="200"
                                        height="200"
                                    />
                                </figure>
                            </div>
                            <div class="p-3 text-center">
                                <div class="text-2xl py-4">{{ $tech['title'] }}</div>
                                <div class="text-lg font-light">{!! $tech['content'] !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section>
            <div class="container py-8 lg:py-16">
                <div class="flex flex-col lg:flex-row justify-center items-center gap-6 max-w-[900px] mx-auto">
                    <img class="w-40" src="img/qr.png" alt="Bitcoin wallet qr code" />

                    <div class="flex flex-col gap-1">
                        <h2 class="ml-1 text-xl lg:text-3xl">Show Your Support</h2>
                        <p class="ml-1 text-[.9rem] lg:text-xl">
                            The best way to support me is to star one of my repositories on <a class="text-link hover:text-link-hover underline" href="https://codeberg.org/SerhiiCho" target="_blank" title="Link to Codeberg account">Codeberg</a>.
                            <br>You can also send me BTC for a cup of coffee:
                        </p>
                        <div>
                            <code class="break-all text-sm lg:text-xl bg-inline-code px-2 rounded-sm">bc1qfjrma259z5mhtcaauwk0lpjt3mw2nlgtv8cr2w</code>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
