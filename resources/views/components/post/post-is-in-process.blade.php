<div class="flex items-center gap-10 pt-14 pb-16">
    <img
        src="{{ asset('storage/posts/upcoming.svg') }}"
        alt="Person typing on the keyboard"
        width="170"
        height="170"
    />

    <div class="flex flex-col gap-2 font-post">
        <h2 class="text-3xl">
            This post is currently being in the process of writing
        </h2>
        <p class="text-2xl">
            <a
                href="{{ route('subscribe') }}"
                rel="noreferrer"
                class="text-main">subscribe</a> to get the latest posts or check suggested posts below!
        </p>
    </div>
</div>
