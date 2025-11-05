@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('title', 'Challenge Nol Karbon')

@section('subnav')
    <nav class="hidden items-center gap-4 rounded-full border border-blue-200 bg-white px-6 py-2 text-xs font-semibold text-blue-800 shadow md:flex">
        <a href="{{ route('challenges.index') }}" class="rounded-full px-3 py-1 {{ request()->routeIs('challenges.index') ? 'bg-blue-700 text-white shadow' : '' }}">Challenge</a>
        <a href="{{ route('challenges.dashboard') }}" class="rounded-full px-3 py-1 {{ request()->routeIs('challenges.dashboard') ? 'bg-blue-700 text-white shadow' : '' }}">Dashboard</a>
        <a href="{{ route('challenges.badges') }}" class="rounded-full px-3 py-1 {{ request()->routeIs('challenges.badges') ? 'bg-blue-700 text-white shadow' : '' }}">Badge</a>
    </nav>
@endsection

@section('hero-actions')
    <a href="{{ route('challenges.dashboard') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-700 bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-blue-800">
        <i class="fa-solid fa-chart-line"></i> My Progress
    </a>
    <a href="{{ route('challenges.badges') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white px-6 py-3 text-sm font-semibold text-blue-800 shadow hover:bg-blue-50">
        <i class="fa-solid fa-award"></i> See My Badges
    </a>
@endsection

@section('content')
    <div class="space-y-10">
        <section class="rounded-[40px] border border-blue-200 bg-white p-8 shadow-lg">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-semibold text-blue-900">Total Poin Saya : <span class="text-2xl"> {{ number_format($totalPoints) }}</span></p>
                    <p class="mt-1 text-xs text-slate-500">Tetap konsisten melaporkan aksi hijau untuk naik level lebih cepat.</p>
                </div>
                <div class="flex flex-wrap gap-3 text-xs font-semibold text-blue-700">
                    <a href="{{ route('challenges.dashboard') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-2 shadow">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard Progres
                    </a>
                    <a href="{{ route('challenges.badges') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-2 shadow">
                        <i class="fa-solid fa-medal"></i> Koleksi Badge
                    </a>
                </div>
            </div>

            @if ($activeParticipation)
                <div class="mt-6 rounded-[32px] border border-blue-200 bg-[#f7f5f0] p-6 shadow-inner">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-4">
                        @php
                            $activeCover = $activeParticipation->challenge->cover_image_path;
                            $activeCoverUrl = match (true) {
                                $activeCover && Storage::disk('public')->exists($activeCover) => Storage::url($activeCover),
                                $activeCover && filter_var($activeCover, FILTER_VALIDATE_URL) => $activeCover,
                                default => 'https://images.unsplash.com/photo-1523978591478-c753949ff840?auto=format&fit=crop&w=300&q=80',
                            };
                        @endphp
                        <img src="{{ $activeCoverUrl }}"
                                 alt="Active challenge" class="h-20 w-28 rounded-3xl object-cover shadow">
                            <div>
                                <p class="text-xs uppercase text-blue-600">Challenge Aktif</p>
                                <h3 class="text-lg font-semibold text-blue-900">{{ $activeParticipation->challenge->title }}</h3>
                                <p class="text-xs text-slate-500">Reward: +{{ $activeParticipation->challenge->point_reward }} poin</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3 text-sm">
                            <div class="flex items-center gap-3 text-xs font-semibold text-slate-500">
                                <span>Progress</span>
                                <span>{{ round($activeParticipation->progress_percentage) }}%</span>
                            </div>
                            <div class="h-2 w-48 rounded-full bg-slate-200">
                                <div class="h-2 rounded-full bg-blue-700" style="width: {{ min(100, $activeParticipation->progress_percentage) }}%"></div>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('challenges.progress.create', $activeParticipation->challenge) }}"
                                   class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-800">
                                    <i class="fa-solid fa-pen-nib"></i> Report Progress
                                </a>
                                <a href="{{ route('challenges.show', $activeParticipation->challenge) }}"
                                   class="inline-flex items-center gap-2 rounded-full border border-blue-200 px-4 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-50">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>

        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-blue-900">Tantangan Tersedia</h2>
                <form method="GET" class="flex flex-wrap items-center gap-3 text-xs font-semibold text-blue-700">
                    <input type="hidden" name="status" value="{{ $filters['status'] }}">
                    <input type="hidden" name="visibility" value="{{ $filters['visibility'] }}">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="search" name="q" value="{{ $filters['search'] }}"
                               class="h-10 rounded-full border border-blue-200 bg-white px-11 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                               placeholder="Cari tantangan...">
                    </div>
                    <select name="status"
                            class="h-10 rounded-full border border-blue-200 bg-white px-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="">Semua status</option>
                        @foreach (['active' => 'Aktif', 'upcoming' => 'Mendatang', 'completed' => 'Selesai', 'draft' => 'Draft'] as $value => $label)
                            <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="visibility"
                            class="h-10 rounded-full border border-blue-200 bg-white px-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="">Semua akses</option>
                        @foreach (['public' => 'Publik', 'private' => 'Private'] as $value => $label)
                            <option value="{{ $value }}" @selected($filters['visibility'] === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-800">
                        Terapkan
                    </button>
                </form>
            </div>

            <div class="space-y-6">
                @forelse ($challenges as $challenge)
                    <article class="grid gap-4 rounded-[32px] border border-blue-200 bg-white p-6 shadow-lg md:grid-cols-[160px,1fr,auto] md:items-center">
                        @php
                            $coverPath = $challenge->cover_image_path;
                            $coverUrl = match (true) {
                                $coverPath && Storage::disk('public')->exists($coverPath) => Storage::url($coverPath),
                                $coverPath && filter_var($coverPath, FILTER_VALIDATE_URL) => $coverPath,
                                default => 'https://images.unsplash.com/photo-1523978591478-c753949ff840?auto=format&fit=crop&w=340&q=80',
                            };
                        @endphp
                        <img src="{{ $coverUrl }}"
                             alt="{{ $challenge->title }}" class="h-36 w-full rounded-3xl object-cover shadow md:h-32 md:w-40">
                        <div class="space-y-2 text-sm">
                            <div class="flex flex-wrap items-center gap-3 text-xs font-semibold uppercase text-blue-700">
                                <span>{{ ucfirst($challenge->status) }}</span>
                                <span>{{ $challenge->point_reward }} poin</span>
                            </div>
                            <h3 class="text-lg font-semibold text-blue-900">{{ $challenge->title }}</h3>
                            <p class="text-slate-600">{{ Str::limit($challenge->description, 150) }}</p>
                            <p class="text-xs text-slate-500">
                                Durasi: {{ optional($challenge->start_date)->translatedFormat('d M Y') ?? 'Fleksibel' }} -
                                {{ optional($challenge->end_date)->translatedFormat('d M Y') ?? 'Berjalan' }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-3 text-xs font-semibold text-blue-700">
                            <a href="{{ route('challenges.show', $challenge) }}"
                               class="inline-flex items-center justify-center gap-2 rounded-full border border-blue-200 px-5 py-2 hover:bg-blue-50">
                                Detail Challenge
                            </a>
                            <a href="{{ route('challenges.join', $challenge) }}"
                               class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-700 px-5 py-2 text-white hover:bg-blue-800">
                                Ikuti Tantangan
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-blue-200 bg-white px-6 py-12 text-center text-sm text-blue-600">
                        Belum ada tantangan baru saat ini.
                    </div>
                @endforelse
            </div>

            <div class="flex justify-center">
                {{ $challenges->links() }}
            </div>
        </section>
    </div>
@endsection
