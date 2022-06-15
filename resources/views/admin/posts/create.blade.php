@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-3xl font-bold text-font-second">Basic information</h1>
        <h2 class="text-xl">Enter title for the future blog post.</h2>

        <form action="{{ route('admin.posts.store') }}" method="post" class="mt-5">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-[3fr_1fr]  gap-3 max-w-3xl">
                <x-admin.input type="text"
                    name="title"
                    placeholder="Enter the title"
                    :required="true"
                />

                <x-admin.button>
                    <i class="fas fa-plus mr-2"></i>
                    <span>Create post</span>
                </x-admin.button>
            </div>
        </form>
    </div>
@endsection
