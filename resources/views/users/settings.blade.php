@php
    use App\Models\User;

    /**
     * @var User $user
     */
@endphp

@extends('layouts.user')

@push('title', "Settings for {$user->name}")

@section('content')
    <div class="container">
        //
    </div>
@endsection
