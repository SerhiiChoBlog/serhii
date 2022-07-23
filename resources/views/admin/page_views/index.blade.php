@extends('layouts.admin')

@section('content')
    <div class="container max-w-3xl">
        <x-admin.page-title>Post views</x-admin.page-title>

        <x-admin.tabs :tabs="[
            ['title' => 'Unique views', 'href' => '#all-views'],
            ['title' => 'Daily views', 'href' => '#daily-views'],
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
            <div class="overflow-x-auto shadow-md rounded-lg mx-auto">
                <table class="table-auto w-full">
                    <thead class="bg-gray-500 text-white text-left">
                    <tr>
                        @foreach (['Date', 'Views'] as $title)
                            <th class="p-3 font-light">{{ $title }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($daily as $day)
                        <tr class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-100 {{ $day->date === date('Y-m-d') ? '!bg-yellow-100' : '' }}">
                            <td class="px-3 py-1">{{ date('d/m/Y', strtotime($day->date)) }}</td>
                            <td class="px-3 py-1">{{ $day->amount }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
