<div class="pt-10 lg:pt-16 h-full">
    <div class="hidden lg:block">
        <nav class="min-h-[83px] mb-7">
            <x-post.sidebar-title>Share this post</x-post.sidebar-title>
            <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
        </nav>
    </div>

    <div class="h-[94%] lg:h-full fixed bg-page w-full max-w-sm left-1/2 -translate-x-1/2 border lg:border-none top-[3%] lg:top-0 bottom-[3%] p-4 lg:p-0 rounded-2xl shadow-xl lg:shadow-none lg:relative">
        <nav class="sticky h-screen overflow-y-scroll top-3">
            <x-post.sidebar-title>Chapters</x-post.sidebar-title>
            <chapters slug="{{ $post['slug'] }}" />
        </nav>
    </div>
</div>
