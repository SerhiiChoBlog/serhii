@extends('layouts.admin')

@section('content')
    <div class="container max-w-3xl">
        <x-admin.page-title>Page views</x-admin.page-title>

        <x-admin.tabs :tabs="[
            ['title' => 'Unique page views', 'href' => '#all-views'],
            ['title' => 'Daily page views', 'href' => '#daily-views'],
        ]" />

        <div id="all-views">
            <div class="overflow-x-auto shadow-md rounded-lg mx-auto">
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

        <div id="daily-views">
            <h4>NICE</h4>
        </div>
    </div>
@endsection
