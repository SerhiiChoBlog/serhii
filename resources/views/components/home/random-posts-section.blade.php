@php
    /** @var array[] $posts */
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 overflow-x-hidden">
    @foreach ($posts as $post)
        @if ($loop->iteration > 3)
            <x-posts.horizontal-post
                class="max-w-md lg:max-w-none mx-auto lg:mx-0 lg:col-span-4"
                :post="$post"
                :lazy="true"
            />
        @else
            <x-posts.vertical-post :post="$post" />
        @endif
    @endforeach
</div>
