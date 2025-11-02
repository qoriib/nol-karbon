@php use Illuminate\Support\Str; @endphp

@extends('layouts.challenge')

@section('title', 'Leaderboard Tantangan')

@section('back-link')
    <a href="{{ route('challenges.index') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white px-4 py-2 text-xs font-semibold text-blue-900 shadow hover:bg-blue-50">
        <i class="fa-solid fa-arrow-left-long"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="space-y-8">
        <section class="rounded-[48px] border border-blue-200 bg-white p-8 shadow-lg">
            <div class="rounded-[32px] bg-blue-800 px-6 py-3 text-center text-sm font-semibold uppercase tracking-[0.4em] text-white">
                Leaderboard Challenge
            </div>
            <form method="GET" class="mt-6 flex flex-col gap-4 text-sm md:flex-row md:items-center md:justify-center">
                <label for="challenge_id" class="text-slate-500">Filter Tantangan:</label>
                <select id="challenge_id" name="challenge_id"
                        class="rounded-full border border-blue-200 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    <option value="">Semua Tantangan</option>
                    @foreach ($challenges as $item)
                        <option value="{{ $item->id }}" @selected($activeChallengeId === $item->id)>{{ $item->title }}</option>
                    @endforeach
                </select>
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-blue-700 px-6 py-2 font-semibold text-white hover:bg-blue-800">
                    Terapkan
                </button>
            </form>
        </section>

        <section class="rounded-[48px] border border-blue-200 bg-white p-8 shadow-lg">
            <div class="grid gap-4">
                @forelse ($participants as $rank => $participant)
                    <article class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm">
                        <div class="flex items-center gap-4">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-base font-semibold text-blue-800">
                                #{{ $rank + 1 }}
                            </span>
                            <div>
                                <p class="text-base font-semibold text-slate-900">{{ $participant->user?->name ?? 'Peserta' }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ $participant->challenge?->title ?? 'Tantangan' }} •
                                    Progres {{ round($participant->progress_percentage) }}%
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-6">
                            <div class="text-right">
                                <p class="text-xs uppercase text-slate-400">Poin</p>
                                <p class="text-lg font-semibold text-slate-900">{{ $participant->points_earned }}</p>
                            </div>
                            <div class="hidden items-center gap-2 rounded-xl bg-white px-4 py-2 text-xs font-semibold text-blue-700 md:flex">
                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                {{ optional($participant->last_reported_at)->diffForHumans() ?? 'Belum ada laporan' }}
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center text-sm text-slate-500">
                        Belum ada data leaderboard untuk filter ini.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
