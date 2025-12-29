@extends('layouts.main')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        mainTitle="Serhii Cho"
        subtitle="Serhii Cho is a web developer and blogger who is writing about<br />creating fast, robust, premium websites and applications"
        class="bg-linear-to-r from-[#657ca1] via-[#445a7e] to-[#163249] text-white"
    />

    <div class="mt-2 text-xl">
        <section class="text-[1.2rem] px-2 lg:px-6 py-8">
            <div class="container">
                <div class="bg-page -translate-y-16 rounded-xl pt-8">
                    <div class="grid grid-cols-1 gap-x-6 lg:grid-cols-[25%_1fr]">
                        <div class="w-[250px] mx-auto rounded-lg top-36 mb-6">
                            <img
                                src="/storage/serhii-cho.webp"
                                alt="Serhii Cho"
                                class="my-auto rounded-lg mx-auto transition-all duration-500 shadow-lg"
                                width="250"
                                height="250"
                            />
                        </div>

                        <div class="about-me prose-xl prose-h2:mb-6 prose-h2:mt-0">
                            Just another IT wizard summoning bugs and dabbling in all kinds of tech sorcery.
                            On the internet, other wizards call me <strong class="inline-flex items-center gap-1">Serhii Cho</strong>.
                            I build interpreters (
                            <a href="https://github.com/textwire/textwire" target="_blank">Textwire</a>
                            ), libraries for Go, PHP and TypeScript (
                            <a href="https://github.com/SerhiiCho/timeago" target="_blank">Timeago</a>,
                            <a href="https://github.com/smooth-loader/smooth-loader" target="_blank">Smooth Loader</a>,
                            <a href="https://github.com/short-number/short-number" target="_blank">Short Number</a>
                            ), browser extensions (
                            <a href="https://github.com/php-revival/php-revival" target="_blank">PHP Revival</a>,
                            <a href="https://github.com/tab-guardian/tab-guardian" target="_blank">Tab Guardian</a>
                            ), extensions for VS Code and Neovim (
                            <a href="https://github.com/textwire/vscode-textwire" target="_blank">VSCode Textwire</a>,
                            <a href="https://github.com/textwire/textwire.nvim" target="_blank">Textwire.nvim</a>
                            ), and other things like LSP servers, Tree Sitter parsers, that you can find on my
                            <a href="https://github.com/SerhiiCho" target="_blank">GitHub profile page</a>.
                            </p>

                            <p>
                            I worked with various integration services, payment systems and bunch of other services that you
                            can find on my <a href="https://github.com/SerhiiCho" target="_blank">GitHub profile page</a>.
                            I'm not fixed on a specific programming language or framework, I'm open to use whatever is needed
                            to get the job done. If you want to see my code, check out <a href="https://www.youtube.com/@serhiicho" target="_blank">these YouTube videos</a>
                            that I post from time to time just for fun.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-about.section :isDark="true" class="min-h-[500px]">
            <x-section-detail />

            <lazy-loading>
                <testimonials></testimonials>
            </lazy-loading>
        </x-about.section>

        <x-about.section>
            <x-about.tech-section :techs="config('technologies.technologies')" />
        </x-about.section>
    </div>
@endsection
