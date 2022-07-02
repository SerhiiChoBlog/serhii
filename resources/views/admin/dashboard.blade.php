@php
    /**
     * @var array $sections
     * @var array{title:string, value:string} $section
     */
@endphp
@extends('layouts.admin')

@section('content')

<div class="container">
    <x-admin.page-title>Statistics</x-admin.page-title>

    <nav class="flex items-center flex-col lg:flex-row justify-between max-w-[800px] mx-auto gap-9">
        @foreach ($sections as $section)
            <div class="flex flex-col justify-between">
                <div class="text-font-second text-center uppercase text-sm text-font-second tracking-widest">
                    {{ $section['title'] }}
                </div>

                <div class="drop-shadow-md text-2xl text-center font-semibold text-main-dark drop-shadow-md">
                    {{ $section['value'] }}
                </div>
            </div>
        @endforeach
    </nav>
</div>

@endsection
