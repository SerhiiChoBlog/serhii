<div class="bg-gradient-to-t from-[#593468] to-[#423263] text-white h-screen">
    <x-hero class="bg-transparent text-white" />

    <div class="container text-center py-24">
        <h1 class="text-[13rem] font-main font-black leading-[120%]">{{ $code }}</h1>

        <h2 class="flex flex-col text-2xl gap-2 font-post">
            <span>{{ $header }}</span>
            <span>Maybe you will be interested in posts below?</span>
        </h2>

        <div>
            <article></article>
            {{-- POSTS HERE --}}
        </div>

        <subscription :remove-bg="true"></subscription>
    </div>
</div>
