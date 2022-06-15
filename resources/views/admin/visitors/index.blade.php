@extends('layouts.admin')

@section('content')
    <div class="container max-w-3xl">
        <h1 class="text-3xl">Page views</h1>

        <div class="overflow-x-auto shadow-md rounded-lg mx-auto mt-7">
            <table class="table-auto w-full">
                <thead class="bg-gray-500 text-white text-left">
                    <tr>
                        @foreach (['Views', 'IP', 'Country', 'City', 'Flag'] as $title)
                            <th class="p-3">{{ $title }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visitors as $visitor)
                        <tr class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-200">
                            <td class="px-3 py-1">{{ $visitor->page_views_count }}</td>
                            <td class="px-3 py-1">{{ $visitor->ip }}</td>
                            <td class="px-3 py-1">{{ $visitor->country ?? '-' }}</td>
                            <td class="px-3 py-1">{{ $visitor->city ?? '-' }}</td>
                            <td class="px-3 py-1">
                                @if ($visitor->code)
                                    <img src="{{ asset("storage/admin/flags/$visitor->code.png") }}" width="30" />
                                @else
                                    <img src="{{ asset("storage/admin/flags/unknown.png") }}" width="30" />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
