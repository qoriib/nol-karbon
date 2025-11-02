@extends('layouts.dashboard')

@section('title', 'Manajemen Tantangan')
@section('page-title', 'Manajemen Challenge')
@section('page-subtitle', 'Atur tantangan yang aktif di komunitas Nol Karbon.')

@section('content')
    <div class="space-y-10">
        <section class="rounded-[48px] bg-[#e7ddcd] p-8 shadow-lg">
            <div class="flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-medal text-2xl text-blue-800"></i>
                        <h2 class="text-2xl font-semibold text-blue-900">Daftar Challenge</h2>
                    </div>
                    <a href="{{ route('admin.challenges.create') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-blue-800">
                        <i class="fa-solid fa-plus"></i> Tambah Challenge
                    </a>
                </div>

                <form method="GET" class="grid gap-4 md:grid-cols-[2fr,1fr,auto] md:items-end">
                    <div>
                        <label for="search" class="text-xs font-semibold uppercase text-blue-600">Cari Challenge</label>
                        <div class="relative mt-2">
                            <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input id="search" name="q" type="search" value="{{ $filters['search'] }}"
                                   class="w-full rounded-full border border-slate-200 bg-white px-12 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                   placeholder="Cari judul, slug, atau periode">
                        </div>
                    </div>
                    <div>
                        <label for="status" class="text-xs font-semibold uppercase text-blue-600">Status</label>
                        <select id="status" name="status"
                                class="mt-2 w-full rounded-full border border-slate-200 bg-white px-5 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="">Semua Status</option>
                            @foreach (['draft' => 'Draft', 'upcoming' => 'Mendatang', 'active' => 'Aktif', 'completed' => 'Selesai', 'archived' => 'Arsip'] as $value => $label)
                                <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-blue-800">
                        Terapkan
                    </button>
                </form>

                <div class="overflow-hidden rounded-[36px] border border-blue-200 bg-white shadow-inner">
                    <div class="grid grid-cols-[2fr,1fr,1fr,1fr,auto] gap-4 bg-blue-800 px-6 py-4 text-sm font-semibold uppercase tracking-wider text-white">
                        <span>Challenge</span>
                        <span>Periode</span>
                        <span>Poin</span>
                        <span>Status</span>
                        <span class="text-right">Aksi</span>
                    </div>
                    <div class="space-y-2 px-6 py-4">
                        @forelse ($challenges as $challenge)
                            <div class="grid grid-cols-[2fr,1fr,1fr,1fr,auto] items-center gap-4 rounded-3xl bg-[#fdfdfd] px-4 py-4 shadow-sm">
                                <div class="flex flex-col gap-1">
                                    <p class="text-sm font-semibold text-blue-900">{{ $challenge->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $challenge->slug }}</p>
                                </div>
                                <div class="text-sm font-semibold text-blue-800">
                                    {{ optional($challenge->start_date)->translatedFormat('d M Y') ?? 'Fleksibel' }}<br>
                                    <span class="text-xs text-slate-400">s/d {{ optional($challenge->end_date)->translatedFormat('d M Y') ?? 'Berjalan' }}</span>
                                </div>
                                <div class="text-sm font-semibold text-blue-900">
                                    {{ $challenge->point_reward }} poin
                                    @if($challenge->bonus_point)
                                        <span class="block text-xs text-blue-500">+{{ $challenge->bonus_point }} bonus</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                        {{ ucfirst($challenge->status) }}
                                    </span>
                                    <p class="mt-2 text-xs text-slate-500">{{ $challenge->participants_count }} peserta</p>
                                </div>
                                <div class="flex items-center justify-end gap-2 text-xs">
                                    <a href="{{ route('admin.challenges.show', $challenge) }}"
                                       class="inline-flex items-center gap-1 rounded-full border border-blue-200 px-4 py-2 font-semibold text-blue-700 hover:bg-blue-50">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.challenges.edit', $challenge) }}"
                                       class="inline-flex items-center gap-1 rounded-full border border-blue-700 px-4 py-2 font-semibold text-blue-700 hover:bg-blue-50">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.challenges.destroy', $challenge) }}"
                                          onsubmit="return confirm('Hapus tantangan ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-full border border-red-200 px-4 py-2 font-semibold text-red-600 hover:bg-red-50">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-3xl border border-dashed border-blue-200 bg-white px-6 py-12 text-center text-sm text-blue-600">
                                Tidak ada tantangan yang ditemukan. Klik tombol Tambah untuk membuat tantangan baru.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('challenges.leaderboard') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-5 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-200">
                        <i class="fa-solid fa-ranking-star"></i> Leaderboard Challenge
                    </a>
                    {{ $challenges->links() }}
                </div>
            </div>
        </section>
    </div>
@endsection
