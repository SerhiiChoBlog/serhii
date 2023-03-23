@extends('layouts.main')

@push('title', 'Login to your account')
@push('description', 'Login to your account to stay in touch')

@section('content')
    <x-hero class="bg-gray-700" navbar="text-white" />

    <div class="max-w-md mx-auto py-20 min-h-[620px]">
        <login-form :use-as-separate-page="true">
            <h2 class="text-xl lg:text-3xl text-center">Loading...</h2>
        </login-form>
    </div>
@endsection
