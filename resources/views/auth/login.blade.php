@extends('layouts.app')

@section('content')

<div class="flex justify-center py-10">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="hidden" name="email" value="admin@mail.com" required>
        <input type="checkbox" name="remember" class="hidden" checked>

        <input id="password"
            type="password"
            class="px-8 py-3 rounded-full text-center"
            name="password"
            placeholder="404 Page not found"
            required
        >
    </form>
</div>

@endsection
