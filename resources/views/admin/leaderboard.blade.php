@extends('layouts.dashboard')

@section('title', 'Leaderboard Admin')
@section('page-title', 'Leaderboard Platform')
@section('page-subtitle', 'Lihat pencapaian terbaik dari peserta, komunitas, dan challenge.')

@section('content')
    <div class="space-y-10">
        <section class="rounded-[48px] bg-white p-8 shadow-lg">
            <h2 class="text-lg font-semibold text-blue-900">Top Peserta</h2>
            <p class="mt-1 text-sm text-slate-500">10 besar peserta dengan poin tertinggi sepanjang waktu.</p>
            <div class="mt-6 overflow-hidden rounded-[32px] border border-blue-100">
                <table class="min-w-full divide-y divide-blue-100 text-sm">
                    <thead class="bg-blue-800 text-left text-xs font-semibold uppercase tracking-[0.3em] text-white">
                    <tr>
                        <th class="px-6 py-3">Peserta</th>
                        <th class="px-6 py-3">Challenge</th>
                        <th class="px-6 py-3">Progress</th>
                        <th class="px-6 py-3 text-right">Poin</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-50 bg-white">
                    @forelse ($topParticipants as $participant)
                        <tr class="hover:bg-blue-50/70">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-blue-900">{{ $participant->user->name ?? 'Peserta' }}</p>
                                <p class="text-xs text-slate-500">{{ $participant->user->email ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">{{ $participant->challenge->title ?? '-' }}</p>
                                <p class="text-xs text-slate-500">Status: {{ optional($participant->challenge)->status }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ number_format($participant->progress_percentage, 0) }}%</td>
                            <td class="px-6 py-4 text-right font-semibold text-blue-900">{{ number_format($participant->points_earned) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-sm text-blue-600">Belum ada data peserta.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-[48px] bg-white p-8 shadow-lg">
                <h3 class="text-lg font-semibold text-blue-900">Leaderboard Komunitas</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach ($topCommunities as $community)
                        <li class="flex items-center justify-between rounded-3xl border border-blue-100 bg-[#f7f5f0] px-5 py-3">
                            <div>
                                <p class="font-semibold text-blue-900">{{ $community->name }}</p>
                                <p class="text-xs text-slate-500">Reduksi {{ number_format($community->total_emission_reduced, 1) }} kg CO₂</p>
                            </div>
                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">{{ number_format($community->total_points) }} poin</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-[48px] bg-white p-8 shadow-lg">
                <h3 class="text-lg font-semibold text-blue-900">Challenge Paling Ramai</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach ($topChallenges as $challenge)
                        <li class="flex items-center justify-between rounded-3xl border border-blue-100 bg-[#f7f5f0] px-5 py-3">
                            <div>
                                <p class="font-semibold text-blue-900">{{ $challenge->title }}</p>
                                <p class="text-xs text-slate-500">Status: {{ ucfirst($challenge->status) }}</p>
                            </div>
                            <div class="text-right text-xs text-slate-500">
                                <p>{{ $challenge->participants_count }} peserta</p>
                                <p>Reward +{{ $challenge->point_reward }} poin</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </div>
@endsection
