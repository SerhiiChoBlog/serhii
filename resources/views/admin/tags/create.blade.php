@extends('layouts.admin')

@section('content')
    <div class="container">
        <div>
            <x-admin.page-title>Tags</x-admin.page-title>

            <form action="{{ route('admin.tags.store') }}" method="POST" class=" max-w-[1000px] mx-auto">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <x-admin.input name="title" type="text" placeholder="Enter the title">
                        Full title
                    </x-admin.input>

                    <x-admin.input name="name" type="text" placeholder="Enter the slug">
                        Short name (slug)
                    </x-admin.input>

                    <x-admin.input name="color" type="color" class="min-h-[50px]">
                        Choose the color
                    </x-admin.input>
                </div>

                <div class="mt-4">
                    <x-admin.input name="description" type="text" placeholder="Enter the description">
                        Enter the description
                    </x-admin.input>
                </div>

                <div class="mt-7">
                    <x-admin.button>
                        <i class="fas fa-plus mr-2"></i> Create tag
                    </x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection
