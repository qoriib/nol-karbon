@extends('layouts.dashboard')

@section('title', 'User Activity Report')
@section('page-title', 'View User Activity')
@section('page-subtitle', 'Jejak aktivitas pengguna dan dampak reduksi emisi per bulan.')

@section('content')
    <div class="space-y-8">
        <section class="rounded-[48px] border border-blue-200 bg-white p-8 shadow-lg">
            <div class="grid gap-6 md:grid-cols-2">
                <article class="rounded-3xl bg-[#f7f5f0] px-6 py-5 shadow-inner">
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-600">Total Users</p>
                    <p class="mt-3 text-2xl font-semibold text-blue-900">{{ number_format($summary['total_users']) }}</p>
                </article>
                <article class="rounded-3xl bg-[#f7f5f0] px-6 py-5 shadow-inner">
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-600">CO₂ Reduced</p>
                    <p class="mt-3 text-2xl font-semibold text-blue-900">{{ number_format($summary['total_reduction'], 1) }} kg</p>
                </article>
            </div>
        </section>

        <section class="rounded-[48px] border border-blue-200 bg-white p-8 shadow-lg">
            <h2 class="text-lg font-semibold text-blue-900">Ringkasan Aktivitas Emisi</h2>
            <p class="mt-1 text-sm text-slate-500">Reduksi CO₂ per pengguna lintas bulan.</p>

            <div class="mt-6 overflow-hidden rounded-[32px] border border-blue-100">
                <table class="min-w-full divide-y divide-blue-100 text-sm">
                    <thead class="bg-blue-800 text-left text-xs font-semibold uppercase tracking-[0.3em] text-white">
                    <tr>
                        <th class="px-6 py-3">Nama Peserta</th>
                        <th class="px-6 py-3">Bulan</th>
                        <th class="px-6 py-3 text-right">Total Reduksi</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-50 bg-white">
                    @forelse ($monthlyActivities as $userId => $rows)
                        @foreach ($rows as $row)
                            <tr class="hover:bg-blue-50/70">
                                <td class="px-6 py-4 font-semibold text-blue-900">{{ optional($row->user)->name ?? 'Pengguna' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $row->month }}</td>
                                <td class="px-6 py-4 text-right text-blue-700 font-semibold">{{ number_format($row->total_reduction, 1) }} kg</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-sm text-blue-600">Belum ada catatan aktivitas.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-[48px] border border-blue-200 bg-white p-8 shadow-lg">
            <h2 class="text-lg font-semibold text-blue-900">Timeline Aktivitas</h2>
            <div class="mt-6 space-y-4">
                @forelse ($activities as $activity)
                    <article class="rounded-3xl border border-blue-100 bg-[#f7f5f0] px-5 py-4 text-sm text-blue-900">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold">{{ ucfirst(str_replace('_', ' ', $activity->activity_type)) }}</p>
                                <p class="text-xs text-slate-500">{{ optional($activity->occurred_at)->diffForHumans() ?? $activity->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-xs text-slate-500">
                                <span class="block">Pengguna: {{ $activity->user->name ?? '-' }}</span>
                                @if($activity->performedBy)
                                    <span class="block">Dilakukan oleh: {{ $activity->performedBy->name }}</span>
                                @endif
                            </div>
                        </div>
                        @if ($activity->description)
                            <p class="mt-3 text-slate-600">{{ $activity->description }}</p>
                        @endif
                    </article>
                @empty
                    <p class="rounded-3xl border border-dashed border-blue-200 bg-white px-5 py-6 text-center text-sm text-blue-600">Belum ada aktivitas tercatat.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $activities->links() }}
            </div>
        </section>
    </div>
@endsection
