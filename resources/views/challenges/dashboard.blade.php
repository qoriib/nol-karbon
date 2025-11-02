@extends('layouts.challenge')

@section('title', 'Dashboard Progress & Poin')

@section('back-link')
    <a href="{{ route('challenges.index') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white px-4 py-2 text-xs font-semibold text-blue-900 shadow hover:bg-blue-50">
        <i class="fa-solid fa-arrow-left-long"></i> Kembali
    </a>
@endsection

@section('hero-actions')
    <a href="{{ route('challenges.badges') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-blue-800">
        <i class="fa-solid fa-award"></i> See My Badges
    </a>
@endsection

@section('content')
    <div class="mx-auto max-w-4xl">
        <section class="rounded-[48px] border border-blue-200 bg-white p-10 shadow-lg">
            <div class="rounded-[32px] bg-blue-800 px-6 py-3 text-center text-sm font-semibold uppercase tracking-[0.4em] text-white">
                Dashboard Progress & Poin
            </div>

            <div class="mt-8 space-y-8 text-center text-sm text-blue-900">
                <div class="rounded-[32px] border border-blue-200 bg-[#f7f5f0] p-6 shadow-inner">
                    <p class="text-xs font-semibold uppercase text-blue-600">Active Challenge Status</p>
                    @if ($activeChallenges->isNotEmpty())
                        @php
                            $active = $activeChallenges->first();
                        @endphp
                        <h3 class="mt-3 text-xl font-semibold text-blue-900">{{ $active->challenge->title }}</h3>
                        <p class="mt-1 text-xs text-slate-500">
                            Berjalan: {{ optional($active->challenge->start_date)->translatedFormat('d M Y') ?? 'Fleksibel' }}
                        </p>
                        <p class="mt-2 text-xs text-slate-500">Progres: {{ round($active->progress_percentage) }}%</p>
                    @else
                        <p class="mt-3 text-xs text-slate-500">Belum ada tantangan aktif saat ini.</p>
                    @endif
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-[32px] border border-blue-200 bg-white p-6 shadow-sm">
                        <div class="rounded-full bg-blue-800 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white">
                            Total Points
                        </div>
                        <p class="mt-4 text-3xl font-semibold text-blue-900">{{ number_format($totalPoints) }}</p>
                        <p class="mt-1 text-xs text-slate-500">Akumulasi dari seluruh tantangan</p>
                    </div>
                    <div class="rounded-[32px] border border-blue-200 bg-white p-6 shadow-sm">
                        <div class="rounded-full bg-blue-800 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white">
                            Total Finished Challenges
                        </div>
                        <p class="mt-4 text-3xl font-semibold text-blue-900">{{ $completedChallenges->count() }}</p>
                        <p class="mt-1 text-xs text-slate-500">Tantangan yang telah kamu selesaikan</p>
                    </div>
                </div>

                <div class="rounded-[32px] border border-blue-200 bg-white p-6 text-left shadow-sm">
                    <p class="text-xs font-semibold uppercase text-blue-600">Tantangan Aktif</p>
                    <div class="mt-4 space-y-4 text-sm text-slate-600">
                        @forelse ($activeChallenges as $participation)
                            <div class="rounded-3xl border border-blue-200 bg-[#f7f5f0] p-4 shadow-inner">
                                <div class="flex flex-wrap items-center justify-between gap-3 text-xs font-semibold text-blue-900">
                                    <span>{{ $participation->challenge->title }}</span>
                                    <span>{{ round($participation->progress_percentage) }}% progres</span>
                                </div>
                                <p class="mt-2 text-xs text-slate-500">
                                    Reward : +{{ $participation->challenge->point_reward }} poin • Bonus {{ $participation->challenge->bonus_point }}
                                </p>
                            </div>
                        @empty
                            <p class="rounded-2xl border border-dashed border-blue-200 bg-white px-6 py-6 text-center text-xs text-blue-600">
                                Belum ada tantangan aktif. Ayo bergabung dari halaman Challenge.
                            </p>
                        @endforelse
                    </div>
                </div>

                <a href="{{ route('challenges.index') }}"
                   class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                    Return to the Challenge
                </a>
            </div>
        </section>
    </div>
@endsection
