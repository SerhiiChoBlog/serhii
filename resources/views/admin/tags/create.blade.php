@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="border-b pb-7 mb-7 lg:border-none lg:pb-0 lg:mb-0">
            <x-admin.page-title>Tags</x-admin.page-title>

            <div class="px-4">
                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf

                    <div class="space-y-5">
                        <div>
                            <x-admin.input name="name" type="text" placeholder="Enter the tag name">
                                Name
                            </x-admin.input>
                        </div>

                        <div>
                            <x-admin.input name="color" type="color" class="min-h-[50px]">Choose the color</x-admin.input>
                        </div>

                        <div>
                            <x-admin.button>
                                <i class="fas fa-plus mr-2"></i> Create tag
                            </x-admin.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
