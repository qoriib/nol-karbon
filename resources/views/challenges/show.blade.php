@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('title', $challenge->title . ' | Nol Karbon Challenge')

@section('back-link')
    <a href="{{ route('challenges.index') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white px-4 py-2 text-xs font-semibold text-blue-900 shadow hover:bg-blue-50">
        <i class="fa-solid fa-arrow-left-long"></i>
        Kembali
    </a>
@endsection

@section('content')
    <div class="space-y-8">
        <section class="rounded-[48px] border border-blue-200 bg-white p-10 shadow-lg">
            <div class="rounded-[32px] bg-blue-800 px-6 py-3 text-center text-sm font-semibold uppercase tracking-[0.4em] text-white">
                Detail Challenge
            </div>

            <div class="mt-8 grid gap-8 lg:grid-cols-[1.2fr,0.8fr]">
                <div class="space-y-6 text-sm leading-relaxed text-slate-700">
                    <div class="rounded-[32px] border border-blue-200 bg-[#f7f5f0] p-6 shadow-inner">
                        <p class="text-xs font-semibold uppercase text-blue-600">Weekly Challenge</p>
                        <h1 class="mt-2 text-2xl font-semibold text-blue-900">{{ $challenge->title }}</h1>
                        <p class="mt-4 whitespace-pre-line">{{ $challenge->description }}</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-[28px] border border-blue-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-semibold uppercase text-blue-600">Periode</p>
                            <p class="mt-2 text-sm font-semibold text-blue-900">
                                {{ optional($challenge->start_date)->translatedFormat('d M Y') ?? 'Fleksibel' }} -
                                {{ optional($challenge->end_date)->translatedFormat('d M Y') ?? 'Berjalan' }}
                            </p>
                            <p class="mt-1 text-xs text-slate-500">Status: {{ ucfirst($challenge->status) }}</p>
                        </div>
                        <div class="rounded-[28px] border border-blue-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-semibold uppercase text-blue-600">Reward</p>
                            <p class="mt-2 text-sm font-semibold text-blue-900">{{ $challenge->point_reward }} poin</p>
                            <p class="mt-1 text-xs text-slate-500">Bonus {{ $challenge->bonus_point }} poin</p>
                        </div>
                    </div>

                    <div class="rounded-[32px] border border-blue-200 bg-white p-6 shadow-sm">
                        <p class="text-xs font-semibold uppercase text-blue-600">Instruksi</p>
                        <div class="mt-3 text-slate-600">
                            {!! nl2br(e($challenge->instructions ?? 'Ikuti aturan tantangan, laporkan progres rutin, dan unggah bukti aktivitas.')) !!}
                        </div>
                    </div>

                    @if ($challenge->requirements)
                        <div class="rounded-[32px] border border-blue-200 bg-white p-6 shadow-sm">
                            <p class="text-xs font-semibold uppercase text-blue-600">Requirement</p>
                            <ul class="mt-4 grid gap-2 text-sm text-blue-800 md:grid-cols-2">
                                @foreach ($challenge->requirements as $item)
                                    <li class="flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2">
                                        <i class="fa-solid fa-leaf"></i>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <aside class="space-y-6">
                    @php
                        $coverPath = $challenge->cover_image_path;
                        $coverUrl = match (true) {
                            $coverPath && Storage::disk('public')->exists($coverPath) => Storage::url($coverPath),
                            $coverPath && filter_var($coverPath, FILTER_VALIDATE_URL) => $coverPath,
                            default => 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=600&q=80',
                        };
                    @endphp
                    <div class="overflow-hidden rounded-[32px] border border-blue-200 bg-white shadow-lg">
                        <img src="{{ $coverUrl }}"
                             alt="{{ $challenge->title }}" class="h-56 w-full object-cover">
                        <div class="space-y-4 p-6 text-sm text-slate-600">
                            <p><strong>Status</strong> : {{ ucfirst($challenge->status) }}</p>
                            <p><strong>Peserta Aktif</strong> : {{ $challenge->participants_count }}</p>
                            <p><strong>Dibuat oleh</strong> : {{ $challenge->creator?->name ?? 'Tim Nol Karbon' }}</p>
                            <div class="flex flex-col gap-3">
                                <a href="{{ route('challenges.join', $challenge) }}"
                                   class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                                    <i class="fa-solid fa-handshake-angle"></i> Join The Challenge
                                </a>
                                <a href="{{ route('challenges.progress.create', $challenge) }}"
                                   class="inline-flex items-center justify-center gap-2 rounded-full border border-blue-200 px-6 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-50">
                                    <i class="fa-solid fa-pen-nib"></i> Report Progress
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[32px] border border-blue-200 bg-white p-6 shadow-sm">
                        <h3 class="text-base font-semibold text-blue-900">Aktivitas Terbaru</h3>
                        <div class="mt-4 space-y-3">
                            @forelse ($challenge->progressLogs as $log)
                                <article class="rounded-2xl border border-blue-100 bg-[#f7f5f0] p-4 text-xs text-slate-600">
                                    <header class="flex items-center justify-between font-semibold text-blue-700">
                                        <span>{{ ucfirst($log->activity_type) }}</span>
                                        <time datetime="{{ $log->created_at }}">{{ $log->created_at->diffForHumans() }}</time>
                                    </header>
                                    <p class="mt-2 text-slate-700">{{ $log->description }}</p>
                                    @if($log->metric_value)
                                        <p class="mt-2 text-[11px] text-blue-600">
                                            Progres: {{ $log->metric_value }} {{ $log->metric_unit }}
                                        </p>
                                    @endif
                                </article>
                            @empty
                                <p class="rounded-2xl border border-dashed border-blue-200 bg-white px-4 py-6 text-center text-xs text-blue-600">
                                    Belum ada progres terbaru. Jadilah yang pertama melaporkan!
                                </p>
                            @endforelse
                        </div>
                    </div>

                    @if ($relatedChallenges->isNotEmpty())
                        <div class="space-y-3">
                            <h3 class="text-base font-semibold text-blue-900">Tantangan Terkait</h3>
                            @foreach ($relatedChallenges as $related)
                                <a href="{{ route('challenges.show', $related) }}"
                                   class="flex flex-col gap-2 rounded-[28px] border border-blue-200 bg-white px-5 py-4 text-sm shadow-sm transition hover:border-blue-400 hover:text-blue-700">
                                    <span class="text-xs uppercase text-blue-500">{{ ucfirst($related->status) }}</span>
                                    <span class="font-semibold text-blue-900">{{ $related->title }}</span>
                                    <span class="text-slate-500">{{ Str::limit($related->description, 90) }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </aside>
            </div>
        </section>
    </div>
@endsection
