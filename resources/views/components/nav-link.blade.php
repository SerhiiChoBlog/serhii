@php
/**
 * @var string $href
 * @var string $title
 * @var string|null $class
 */
@endphp

<a
    href="{{ $href }}"
    class="relative w-full lg:w-max border-b border-border lg:border-none text-sm lg:text-md before:content-none px-7 py-5 lg:p-0 lg:before:content-[''] navbar-link {{ $class ?? '' }} uppercase lg:drop-shadow-md"
>
    {{ $title }}
</a>
