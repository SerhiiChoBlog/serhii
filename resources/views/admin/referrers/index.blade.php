@php
    /** @var App\Models\Referrer[] $referrers */
    /** @var App\Models\Referrer $referrer */
@endphp

@extends('layouts.admin')

@section('content')
    <div class="container">
        <x-admin.page-title>Referrers</x-admin.page-title>

        <div>
            @empty($referrers->all())
                <h2 class="text-2xl text-center">There are not referrers</h2>
            @else
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg max-w-[1100px] mx-auto">
                    <table class="w-full">
                        <thead class="bg-gray-500 text-left">
                        <tr>
                            @foreach (['#', 'Name', 'Site', 'Hits', 'Hash', 'Last update'] as $title)
                                <th class="text-white p-3 font-light">{{ $title }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($referrers as $referrer)
                            <tr class="odd:bg-gray-50 border-b transition-colors hover:bg-gray-100">
                                <td class="p-2">{{ $referrer->id }}</td>
                                <td class="p-2">{{ $referrer->name }}</td>
                                <td class="p-2">{{ $referrer->site }}</td>
                                <td class="p-2 text-lg font-black text-main font-code">{{ $referrer->hits }}</td>
                                <td class="p-2">
                                    <code class="bg-gray-200 py-1 px-3 rounded-md font-code">
                                        {{ $referrer->hash }}
                                    </code>
                                </td>
                                <td class="p-2">{{ $referrer->pretty_updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endempty
        </div>
    </div>
@endsection
