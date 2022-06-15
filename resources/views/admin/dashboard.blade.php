@php
    /**
     * @var array $sections
     * @var array{title:string, value:string} $section
     */
@endphp
@extends('layouts.admin')

@section('content')

<div class="container">
    <nav class="flex items-center space-y-6 flex-col lg:flex-row justify-between mx-auto max-w-4xl">
        @foreach ($sections as $section)
            <div class="flex flex-col space-y-2">
                <p class="text-font-second text-center uppercase text-xs text-gray-500 tracking-widest">
                    {{ $section['title'] }}
                </p>

                <p class="drop-shadow-md text-3xl text-center font-semibold">
                    {{ $section['value'] }}
                </p>
            </div>
        @endforeach
    </nav>
</div>

@endsection
