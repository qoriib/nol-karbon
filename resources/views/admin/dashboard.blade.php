@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Hai, Miguel')
@section('page-subtitle', 'Pantau perkembangan Nol Karbon di seluruh kampus dan komunitas.')

@section('content')
    <div class="space-y-8">
        <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($overview as $card)
                <article class="rounded-3xl bg-white px-6 py-6 shadow-lg">
                    <div class="flex items-start justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                            <i class="{{ $card['icon'] }}"></i>
                        </div>
                        <span class="rounded-full bg-blue-100 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.4em] text-blue-700">
                            {{ $card['delta'] }}
                        </span>
                    </div>
                    <p class="mt-5 text-2xl font-semibold text-blue-900">{{ $card['value'] }}</p>
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-600">{{ $card['label'] }}</p>
                    <p class="mt-2 text-xs text-slate-500">{{ $card['subtitle'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="grid gap-6 lg:grid-cols-[1.2fr,0.8fr]">
            <div class="rounded-[48px] border border-blue-200 bg-white p-8 shadow-lg">
                <h2 class="text-lg font-semibold text-blue-900">Card</h2>
                <div class="mt-6 rounded-[36px] border border-blue-100 bg-[#f7f5f0] px-6 py-10 text-center shadow-inner">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                        <i class="fa-solid fa-id-card text-2xl"></i>
                    </div>
                    <p class="mt-4 text-3xl font-semibold text-blue-900">{{ number_format($totalEmissionCards) }}</p>
                    <p class="text-xs text-slate-500">Users telah mencetak Nol Karbon Emission Card</p>
                </div>
            </div>
            <div class="space-y-6">
                <div class="rounded-[48px] border border-blue-200 bg-white p-8 shadow-lg">
                    <h2 class="text-lg font-semibold text-blue-900">Draft</h2>
                    <div class="mt-6 space-y-3 text-sm">
                        <div class="flex items-center justify-between rounded-3xl border border-blue-100 bg-[#f7f5f0] px-5 py-3">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                                    <i class="fa-solid fa-file-lines"></i>
                                </span>
                                <span class="font-semibold text-blue-900">Submitted Draft</span>
                            </div>
                            <span class="text-xs font-semibold text-blue-700">{{ number_format($draftStats['submitted']) }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-3xl border border-blue-100 bg-[#f7f5f0] px-5 py-3">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                                    <i class="fa-solid fa-clock"></i>
                                </span>
                                <span class="font-semibold text-blue-900">Unreviewed Draft</span>
                            </div>
                            <span class="text-xs font-semibold text-blue-700">{{ number_format($draftStats['unreviewed']) }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-3xl border border-blue-100 bg-[#f7f5f0] px-5 py-3">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-green-700">
                                    <i class="fa-solid fa-circle-check"></i>
                                </span>
                                <span class="font-semibold text-blue-900">Approved Draft</span>
                            </div>
                            <span class="text-xs font-semibold text-blue-700">{{ number_format($draftStats['approved']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-[48px] border border-blue-200 bg-white p-8 shadow-lg">
            <h2 class="text-lg font-semibold text-blue-900">Emissions Statistics</h2>
            <p class="mt-1 text-sm text-slate-500">Perbandingan emisi dan reduksi CO₂ per bulan.</p>
            <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4 text-xs uppercase text-blue-600 tracking-[0.3em]">
                @foreach ($emissionTrend as $item)
                    <div class="rounded-3xl border border-blue-100 bg-[#f7f5f0] px-5 py-4 text-blue-900">
                        <p class="text-sm font-semibold text-blue-700">{{ $item->month }}</p>
                        <p class="mt-2 text-xs text-slate-500">Emission: {{ number_format($item->total_emission, 1) }} kg</p>
                        <p class="text-xs text-slate-500">Reduction: {{ number_format($item->total_reduction, 1) }} kg</p>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
