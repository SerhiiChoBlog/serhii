@extends('layouts.user')

@push('title', "Settings for {$user->name}")

@section('content')
    <div class="container">
        <div>
            <h2 class="text-3xl">Delete an account</h2>
            <p class="text-font-second">Delete your account with all the data stored without an option to restore it</p>

            <form
                action="{{ route('users.delete') }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone');"
            >
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    @class([
                        'mt-3',
                        'text-white',
                        'bg-red-700',
                        'hover:bg-red-800',
                        'py-2',
                        'px-4',
                        'rounded-lg',
                    ])
                >
                    Delete Account
                </button>
            </form>
        </div>
    </div>
@endsection
