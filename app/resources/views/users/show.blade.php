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
        <div class="grid grid-cols-1 md:grid-cols-[300px_auto] gap-8 md:gap-12 mx-auto">
            <div>
                <avatar :user="{{ $user->makeHidden(['email', 'email_verified_at']) }}">
                    <div class="h-[250px]"></div>

                </avatar>

                <div class="mt-7 text-center md:text-left">
                    <h1>
                        <span class="font-black text-3xl">{{ $user->name }}</span>

                        @if ($user->id === 1)
                            <small class="text-lg tracking-wider ml-1.5 opacity-80">(admin)</small>
                        @endif
                    </h1>
                    <h2 class="text-lg text-font-second">{{ '@' . $user->slug }}</h2>
                </div>

                <x-users.badges-section :badges="$user->badges"/>
            </div>

            <div>
                @if ($user->ban)
                    <div class="bg-red-50 dark:bg-red-900 p-5 rounded-lg mb-6 flex gap-3 items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-12 h-12"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                            />
                        </svg>

                        <div>
                            <h2 class="text-xl font-bold">User is banned</h2>
                            <h2 class="text-md">{{ $user->ban->comment }}</h2>
                        </div>
                    </div>
                @endif

                <div class="space-y-3">
                    <x-users.profile-row title="Joined">
                        {{ TimeAgo::trans($user->created_at) }}
                    </x-users.profile-row>

                    <x-users.profile-row title="Comments">
                        💬 {{ $user->comments_count ?? 0 }}
                    </x-users.profile-row>

                    <x-users.profile-row title="Likes articles">
                        ❤️ {{ $user->post_likes_count ?? 0 }}
                    </x-users.profile-row>
                </div>

                <div class="mt-8">
                    <h2 class="text-3xl">Last activity</h2>

                    <div class="my-4">
                        <feed slug="{{ $user->slug }}"></feed>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
