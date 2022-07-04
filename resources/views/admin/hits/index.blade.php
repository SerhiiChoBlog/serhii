@php
    use App\Models\Hit;use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * @var LengthAwarePaginator $hits
     * @var Hit $hit
     */
@endphp

@extends('layouts.admin')

@section('content')
    <div class="container max-w-3xl">
        <x-admin.page-title>Request hits</x-admin.page-title>

        <div class="overflow-x-auto shadow-md rounded-lg mx-auto">
            <table class="table-auto w-full">
                <thead class="bg-gray-500 text-white text-left">
                    <tr>
                        @foreach (['Date', 'Hits'] as $title)
                            <th class="p-3 font-light">{{ $title }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hits as $hit)
                        <tr class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-100">
                            <td class="px-3 py-1">{{ $hit->created_at->format('d/m/Y') }}</td>
                            <td class="px-3 py-1">{{ $hit->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="my-7 mx-4">
            {{ $hits->links('vendor.pagination.default') }}
        </div>
    </div>
@endsection
