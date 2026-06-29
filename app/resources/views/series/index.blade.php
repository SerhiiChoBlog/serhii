@php
    use Illuminate\Pagination\LengthAwarePaginator;
    use App\Models\Series;

    /**
     * @var LengthAwarePaginator<Series> $series
     * @var Series $s
     */
@endphp

@extends('layouts.main')

@push('title', 'Series of articles')
@push('description', 'Collection of articles groped by specific topics. Each series contains a number of articles on a specific topic.')

@section('content')
    <x-hero
        mainTitle="Series of articles"
        subtitle="Collection of articles groped by specific topics.<br />Each series contains a number of articles on a specific topic."
        class="bg-linear-to-r from-[#1a1b1b] to-[#2f4343] text-white relative"
        style="background: linear-gradient(90deg, {{ $series->first()->color_from ?? 0 }} 0%, {{ $series->first()->color_to ?? 0 }} 100%)"
    />

    <div class="container">
        <div class="bg-page max-w-[1100px] mx-auto -translate-y-6 rounded-xl px-3 pt-3">
            @if ($series->isEmpty())
                <h2 class="text-center text-xl mt-20">
                    There are no series yet
                </h2>
            @else
                <div class="flex flex-col gap-y-4 mt-4">
                    @foreach($series as $s)
                        <x-series.card :series="$s" />
                    @endforeach

                    <div class="my-6 mx-4">
                        {{ $series->appends(request()->input())->links('vendor.pagination.default') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
