<div class="pt-10 lg:pt-16 h-full">
    <div class="hidden lg:block h-full">
        <nav class="min-h-[83px] mb-7">
            <x-post.sidebar-title>Share this post</x-post.sidebar-title>
            <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
        </nav>

        <div class="h-full relative">
            <nav class="sticky h-screen overflow-y-scroll top-3 px-4">
                <x-post.sidebar-title>Chapters</x-post.sidebar-title>
                <chapters slug="{{ $post['slug'] }}" />
            </nav>
        </div>
    </div>
</div>
