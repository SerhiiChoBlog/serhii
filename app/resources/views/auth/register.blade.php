@extends('layouts.main')

@push('title', 'Create an account')
@push('description', 'Create an account to unlock extra features only for registered users')

@section('content')
    <x-hero class="bg-gray-700" navbar="text-white" />

    <div class="max-w-md mx-auto px-5 py-20 min-h-[620px]">
        <register-form :use-as-separate-page="true">
            <h2 class="text-xl lg:text-3xl text-center">Loading...</h2>
        </register-form>
    </div>
@endsection
