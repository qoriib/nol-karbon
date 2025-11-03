@extends('layouts.dashboard')

@section('title', 'Statistik Emisi')
@section('page-title', 'Statistik Emisi Total')
@section('page-subtitle', 'Monitoring reduksi CO₂ dari seluruh komunitas dan pengguna Nol Karbon.')

@section('content')
    <div class="space-y-10">
        <section class="grid gap-4 md:grid-cols-3">
            <article class="rounded-3xl bg-white px-6 py-5 shadow-lg">
                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-500">Total Emisi</p>
                <p class="mt-4 text-3xl font-semibold text-slate-900">{{ number_format($totalEmission, 1) }} <span class="text-base font-normal text-slate-500">kg CO₂</span></p>
            </article>
            <article class="rounded-3xl bg-white px-6 py-5 shadow-lg">
                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-500">Total Reduksi</p>
                <p class="mt-4 text-3xl font-semibold text-slate-900">{{ number_format($totalReduction, 1) }} <span class="text-base font-normal text-slate-500">kg CO₂</span></p>
            </article>
            <article class="rounded-3xl bg-white px-6 py-5 shadow-lg">
                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-500">Net Emisi</p>
                <p class="mt-4 text-3xl font-semibold text-slate-900">{{ number_format($netEmission, 1) }} <span class="text-base font-normal text-slate-500">kg CO₂</span></p>
            </article>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="rounded-[48px] bg-white p-8 shadow-lg">
                <h2 class="text-lg font-semibold text-blue-900">Reduksi per Komunitas</h2>
                <p class="mt-1 text-sm text-slate-500">Urutan komunitas berdasarkan kontribusi reduksi emisi.</p>
                <div class="mt-6 overflow-hidden rounded-[32px] border border-blue-100">
                    <table class="min-w-full divide-y divide-blue-100 text-sm">
                        <thead class="bg-blue-800 text-left text-xs font-semibold uppercase tracking-[0.3em] text-white">
                        <tr>
                            <th class="px-6 py-3">Komunitas</th>
                            <th class="px-6 py-3">Emisi</th>
                            <th class="px-6 py-3 text-right">Reduksi</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-50 bg-white">
                        @forelse ($communityStats as $stat)
                            <tr class="hover:bg-blue-50/70">
                                <td class="px-6 py-4 font-semibold text-blue-900">{{ $stat->community->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ number_format($stat->total_emission, 1) }} kg</td>
                                <td class="px-6 py-4 text-right font-semibold text-blue-900">{{ number_format($stat->total_reduction, 1) }} kg</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-6 text-center text-sm text-blue-600">Belum ada catatan emisi.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="space-y-6">
                <div class="rounded-[48px] bg-white p-8 shadow-lg">
                    <h3 class="text-lg font-semibold text-blue-900">Top Kontributor Individu</h3>
                    <ul class="mt-4 space-y-3 text-sm">
                        @foreach ($userStats as $stat)
                            <li class="flex items-center justify-between rounded-3xl border border-blue-100 bg-[#f7f5f0] px-5 py-3">
                                <div>
                                    <p class="font-semibold text-blue-900">{{ $stat->user->name ?? 'Pengguna' }}</p>
                                    <p class="text-xs text-slate-500">{{ $stat->user->email ?? '-' }}</p>
                                </div>
                                <div class="text-right text-xs text-slate-500">
                                    <p>Emisi {{ number_format($stat->total_emission, 1) }} kg</p>
                                    <p>Reduksi {{ number_format($stat->total_reduction, 1) }} kg</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="rounded-[48px] bg-white p-8 shadow-lg">
                    <h3 class="text-lg font-semibold text-blue-900">Log Emisi Terbaru</h3>
                    <ul class="mt-4 space-y-2 text-xs text-slate-600">
                        @foreach ($recentRecords as $record)
                            <li class="flex items-center justify-between rounded-3xl border border-blue-100 bg-[#f7f5f0] px-4 py-2">
                                <span class="font-semibold text-blue-900">{{ \Carbon\Carbon::parse($record->recorded_for)->translatedFormat('d M Y') }}</span>
                                <span class="text-right">
                                    <span class="block">Emisi {{ number_format($record->total_emission, 1) }} kg</span>
                                    <span class="block">Reduksi {{ number_format($record->total_reduction, 1) }} kg</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    </div>
@endsection
