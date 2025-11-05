@extends('layouts.app')

@section('title', 'Community Dashboard')

@section('hero')
    <section class="mx-auto w-full max-w-5xl px-6 pt-16 text-center">
        <h1 class="text-3xl font-semibold text-slate-900 sm:text-4xl">View Community Dashboard</h1>
        <p class="mx-auto mt-4 max-w-3xl text-sm text-slate-600">
            Kenali kontributor terbaik dari setiap komunitas kampus dan lihat bagaimana poin mereka menumbuhkan gerakan Nol Karbon.
        </p>
    </section>
@endsection

@section('content')
    <section class="mx-auto w-full max-w-4xl">
        <div class="rounded-[48px] border border-blue-200 bg-white p-6 shadow-2xl sm:p-10">
            <div class="space-y-6">
                @forelse ($entries as $entry)
                    <article class="flex flex-col gap-4 rounded-[32px] border border-[#c4ccff] bg-[#d8ddff] px-6 py-5 shadow-[0_12px_24px_rgba(9,27,121,0.12)] sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-base font-semibold text-blue-900 sm:text-lg">
                                {{ $entry['rank'] }}. {{ $entry['member'] }}
                            </p>
                            <p class="text-sm text-slate-600">{{ $entry['community'] }}</p>
                        </div>
                        <span class="text-lg font-semibold text-[#0a1d7a] sm:text-2xl">
                            {{ number_format($entry['points'], 0, ',', '.') }} poin
                        </span>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-blue-200 bg-white px-6 py-16 text-center text-sm text-blue-700">
                        Belum ada data komunitas untuk ditampilkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
