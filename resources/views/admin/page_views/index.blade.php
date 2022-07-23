@extends('layouts.admin')

@section('content')
    <div>
        <a href="#all-views" class="_tab">Unique page views</a>
        <a href="#daily-views" class="_tab">Daily page views</a>
    </div>

    <div class="container max-w-3xl">
        <div id="all-views">
            <x-admin.page-title>Unique page views</x-admin.page-title>

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
