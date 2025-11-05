@extends('layouts.app')

@section('title', 'Peringkat Kampus Hijau')

@section('hero')
    <section class="mx-auto w-full max-w-5xl px-6 pt-16 text-center">
        <h1 class="text-3xl font-semibold text-blue-900 sm:text-4xl">See your university’s score and rank in the spirit of healthy competition!</h1>
        <p class="mx-auto mt-4 max-w-3xl text-sm text-slate-600">
            Saksikan kontribusi kampus dan komunitasmu dalam menurunkan emisi karbon. Teruskan aksi hijau dan naikkan peringkat di leaderboard Nol Karbon!
        </p>
    </section>
@endsection

@section('content')
    <section class="mx-auto w-full max-w-5xl">
        <div class="rounded-[48px] border border-blue-200 bg-white p-6 shadow-2xl sm:p-10">
            <div class="space-y-5">
                @forelse ($leaderboard as $row)
                    <article class="flex items-center gap-4 rounded-[32px] border border-[#c4ccff] bg-[#d8ddff] px-5 py-4 shadow-[0_12px_24px_rgba(9,27,121,0.12)] sm:gap-6 sm:px-8 sm:py-6">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#0a1d7a] shadow-xl">
                            <i class="fa-solid fa-landmark text-2xl text-yellow-200"></i>
                        </div>
                        <div class="flex-1 text-left">
                            <p class="text-sm font-semibold text-blue-900 sm:text-base">
                                {{ $row['rank'] }}. {{ $row['name'] }}
                            </p>
                            <p class="text-xs text-slate-600 sm:text-sm">Emisi {{ number_format($row['emission'], 0) }} Kg CO₂</p>
                        </div>
                        <div class="flex flex-col items-end gap-2 text-right">
                            <span class="text-lg font-semibold text-[#0a1d7a] sm:text-2xl">{{ $row['score'] }}%</span>
                            <div class="h-2 w-24 rounded-full bg-white/60 sm:h-2.5 sm:w-28">
                                <div class="h-full rounded-full bg-[#0a1d7a]" style="width: {{ min($row['score'], 100) }}%;"></div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-blue-200 bg-white px-6 py-12 text-center text-sm text-blue-700">
                        Belum ada data komunitas untuk ditampilkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
