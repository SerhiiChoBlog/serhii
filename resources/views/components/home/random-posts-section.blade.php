@php
    /** @var array[] $posts */
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 overflow-x-hidden">
    @foreach ($posts as $post)
        <x-posts.vertical-post :post="$post" />
    @endforeach
</div>
