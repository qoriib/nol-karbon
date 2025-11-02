@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.dashboard')

@section('title', 'Kelola ' . $challenge->title)
@section('page-title', 'Detail Tantangan')
@section('page-subtitle', 'Lihat ringkasan status tantangan dan peserta aktif.')

@section('content')
    <div class="space-y-8">
        <section class="rounded-[48px] bg-[#e7ddcd] p-8 shadow-lg">
            <div class="rounded-[32px] border border-blue-200 bg-white p-8 shadow-md">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="max-w-3xl">
                        <p class="text-xs uppercase tracking-[0.4em] text-blue-500">Kelola Tantangan</p>
                        <h1 class="mt-3 text-3xl font-semibold text-blue-900">{{ $challenge->title }}</h1>
                        <p class="mt-4 text-sm text-slate-600">{{ $challenge->description }}</p>
                        <dl class="mt-6 grid gap-5 text-sm text-slate-600 md:grid-cols-2">
                            <div>
                                <dt class="text-xs uppercase text-blue-500">Status</dt>
                                <dd class="mt-2 inline-flex rounded-full bg-blue-100 px-4 py-2 text-xs font-semibold text-blue-700">
                                    {{ ucfirst($challenge->status) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase text-blue-500">Periode</dt>
                                <dd class="mt-2 font-semibold text-blue-900">
                                    {{ optional($challenge->start_date)->translatedFormat('d M Y') ?? 'Fleksibel' }}
                                    <span class="text-xs text-slate-400">s/d</span>
                                    {{ optional($challenge->end_date)->translatedFormat('d M Y') ?? 'Berjalan' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase text-blue-500">Reward</dt>
                                <dd class="mt-2 text-sm font-semibold text-blue-900">
                                    {{ $challenge->point_reward }} poin
                                    <span class="block text-xs text-blue-500">Bonus {{ $challenge->bonus_point }} poin</span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase text-blue-500">Peserta</dt>
                                <dd class="mt-2 text-sm font-semibold text-blue-900">
                                    {{ $challenge->participants_count }} aktif
                                    <span class="block text-xs text-slate-400">Kuota {{ $challenge->max_participants ?? 'Tidak dibatasi' }}</span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div class="flex flex-col gap-3 text-sm">
                        <a href="{{ route('admin.challenges.edit', $challenge) }}"
                           class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-6 py-3 font-semibold text-white hover:bg-blue-800">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Tantangan
                        </a>
                        <form method="POST" action="{{ route('admin.challenges.destroy', $challenge) }}"
                              onsubmit="return confirm('Hapus tantangan ini beserta data terkait?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-red-200 px-6 py-3 font-semibold text-red-600 hover:bg-red-50">
                                <i class="fa-solid fa-trash"></i> Hapus Tantangan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-[48px] bg-[#e7ddcd] p-8 shadow-lg">
            <div class="rounded-[32px] border border-blue-200 bg-white p-8 shadow-md">
            <h2 class="text-lg font-semibold text-slate-900">Peserta Aktif</h2>
            <p class="mt-1 text-sm text-slate-600">Pantau progres dan poin peserta yang saat ini mengikuti tantangan.</p>
            <div class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($challenge->participants as $participant)
                    <article class="rounded-3xl border border-blue-100 bg-[#f7f5f0] p-5 text-sm shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-sm font-semibold text-blue-900 shadow">
                                {{ Str::of($participant->user?->name)->substr(0, 2)->upper() }}
                            </span>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $participant->user?->name ?? 'Peserta' }}</p>
                                <p class="text-xs text-slate-500">Status: {{ ucfirst($participant->status) }}</p>
                            </div>
                        </div>
                        <dl class="mt-3 space-y-2 text-xs text-slate-500">
                            <div class="flex justify-between">
                                <dt>Poin</dt>
                                <dd class="font-semibold text-slate-900">{{ $participant->points_earned }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Progres</dt>
                                <dd>{{ round($participant->progress_percentage) }}%</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Terakhir lapor</dt>
                                <dd>{{ optional($participant->last_reported_at)->diffForHumans() ?? 'Belum ada' }}</dd>
                            </div>
                        </dl>
                    </article>
                @empty
                    <p class="rounded-3xl border border-dashed border-blue-200 bg-blue-50 px-6 py-10 text-center text-sm text-blue-600">
                        Belum ada peserta yang bergabung.
                    </p>
                @endforelse
            </div>
            </div>
        </section>
    </div>
@endsection
