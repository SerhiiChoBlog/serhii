@extends('layouts.admin')

@section('content')
    <div class="container max-w-3xl">
        <h1 class="text-3xl">Page views</h1>

        <div class="overflow-x-auto shadow-md rounded-lg mx-auto mt-7">
            <table class="table-auto w-full">
                <thead class="bg-gray-500 text-white text-left">
                    <tr>
                        @foreach (['Views', 'Page slug'] as $title)
                            <th class="p-3 font-light">{{ $title }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($views as $view)
                        <tr class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-100">
                            <td class="px-3 py-1">{{ $view->amount }}</td>
                            <td class="px-3 py-1">{{ $view->slug }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
