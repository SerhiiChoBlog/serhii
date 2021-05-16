@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input type="hidden" name="email" value="admin@mail.com" required>
                <input type="hidden" name="remember" checked>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="control">
                        <input id="password" type="password" class="input" name="password" placeholder="Enter the password..." required>
                    </div>
                </div>

                <button type="submit" class="button is-info">Login</button>
            </form>
        </div>
    </div>
</div>

@endsection
