@extends('layouts.challenge')

@section('title', 'Badge & Level Nol Karbon')

@section('back-link')
    <a href="{{ route('challenges.index') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white px-4 py-2 text-xs font-semibold text-blue-900 shadow hover:bg-blue-50">
        <i class="fa-solid fa-arrow-left-long"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="mx-auto max-w-4xl space-y-8">
        <section class="rounded-[48px] border border-blue-200 bg-white p-10 text-center shadow-lg">
            <div class="rounded-[32px] bg-blue-800 px-6 py-3 text-sm font-semibold uppercase tracking-[0.4em] text-white">
                Badge Collection & User Level
            </div>
            <p class="mt-6 text-sm text-slate-600">
                Koleksi pencapaianmu sebagai bagian dari komunitas Nol Karbon terus bertambah seiring aksi positif yang kamu lakukan.
            </p>

            <div class="mt-8 grid gap-4 text-sm text-blue-900 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-[28px] border border-blue-200 bg-[#f7f5f0] p-6 shadow-inner">
                    <p class="text-xs font-semibold uppercase text-blue-600">Level Saat Ini</p>
                    <p class="mt-3 text-3xl font-semibold text-blue-900">Level {{ $level }}</p>
                    <p class="mt-2 text-xs text-slate-500">Eco Hero</p>
                </div>
                <div class="rounded-[28px] border border-blue-200 bg-[#f7f5f0] p-6 shadow-inner">
                    <p class="text-xs font-semibold uppercase text-blue-600">Total Poin</p>
                    <p class="mt-3 text-3xl font-semibold text-blue-900">{{ number_format($totalPoints) }}</p>
                    <p class="mt-2 text-xs text-slate-500">Kumpulkan {{ max(0, $nextLevelPoints) }} poin lagi untuk naik level.</p>
                </div>
                <div class="rounded-[28px] border border-blue-200 bg-[#f7f5f0] p-6 shadow-inner">
                    <p class="text-xs font-semibold uppercase text-blue-600">Total Badge</p>
                    <p class="mt-3 text-3xl font-semibold text-blue-900">{{ collect($badges)->filter(fn ($badge) => $badge['earned_at'])->count() }}</p>
                    <p class="mt-2 text-xs text-slate-500">Terus ikuti tantangan untuk melengkapi semuanya.</p>
                </div>
            </div>
        </section>

        <section class="rounded-[48px] border border-blue-200 bg-white p-10 shadow-lg">
            <h2 class="text-lg font-semibold text-blue-900">Level {{ $level }} - Eco Hero</h2>
            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                @foreach ($badges as $badge)
                    <article class="rounded-[32px] border border-blue-200 bg-[#f7f5f0] p-6 text-center shadow-inner">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white shadow">
                            <i class="fa-solid fa-medal text-2xl text-blue-700"></i>
                        </div>
                        <h3 class="mt-4 text-base font-semibold text-blue-900">{{ $badge['name'] }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $badge['description'] }}</p>
                        @if ($badge['earned_at'])
                            <p class="mt-4 inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-2 text-xs font-semibold text-green-700">
                                <i class="fa-solid fa-check"></i> Diraih {{ $badge['earned_at']->diffForHumans() }}
                            </p>
                        @else
                            <p class="mt-4 inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-2 text-xs font-semibold text-blue-700">
                                <i class="fa-solid fa-hourglass-half"></i> Belum diraih
                            </p>
                        @endif
                    </article>
                @endforeach
            </div>

            <a href="{{ route('challenges.index') }}"
               class="mt-8 inline-flex w-full items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                Return to the Challenge
            </a>
        </section>
    </div>
@endsection
