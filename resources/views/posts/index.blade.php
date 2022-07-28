@extends('layouts.app')

@section('title', 'Blog for web developers')
@section('description', "I'm writing articles about programming, productivity and happiness in general. I'm writing everything that can potentially benefit me and increase my productivity.")

@section('content')
    <x-hero title="Blog for web developers"
        subtitle="I'm writing articles about programming, productivity and happiness in general.<br>I'm writing everything that can potentially benefit me and increase my productivity."
        class="bg-gradient-to-r from-[#d074a2] to-[#2a4b67] text-white"
    />

    <posts></posts>
@endsection
