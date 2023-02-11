@php
    use App\Models\User;
    use Serhii\Ago\TimeAgo;

    /**
     * @var User $user
     */
@endphp

@extends('layouts.user')

@push('title', $user->name)

@section('content')
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-[300px_auto] gap-8 md:gap-12 max-w-[900px] mx-auto">
            <div>
                <avatar :user="{{ $user }}">
                    <div class="h-[250px]"></div>
                </avatar>

                <div class="mt-7 text-center md:text-left">
                    <h1 class="text-3xl font-black">{{ $user->name }}</h1>
                    <h2 class="text-lg text-font-second">{{ '@' . $user->slug }}</h2>
                </div>

                <x-users.badges-section :badges="$user->badges"/>
            </div>

            <div>
                <div class="space-y-3">
                    <x-users.profile-row title="Joined">
                        {{ TimeAgo::trans($user->created_at) }}
                    </x-users.profile-row>
                    <x-users.profile-row title="Comments">
                        {{ $user->comments_count ?? 0 }}
                    </x-users.profile-row>
                    <x-users.profile-row title="Posts liked">
                        <span class="text-yellow-600">coming soon</span>
                    </x-users.profile-row>
                </div>
            </div>
        </div>
    </div>
@endsection
