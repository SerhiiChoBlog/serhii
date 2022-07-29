@extends('layouts.app')

@section('title', 'Blog for developers')
@section('description', "Articles about programming and web development that will benefit you and increase your productivity")

@section('content')
    <x-hero title="Blog for developers"
        subtitle="Articles about programming and web development.<br>You can find everything that can potentially benefit you and increase your productivity."
        class="bg-gradient-to-r from-[#d074a2] to-[#2a4b67] text-white"
    />

    <posts tag-slug="{{ request('tag') }} "></posts>
@endsection
