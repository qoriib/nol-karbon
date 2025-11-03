@extends('layouts.dashboard')

@section('title', 'Aktivitas Pengguna')
@section('page-title', 'Aktivitas Pengguna')
@section('page-subtitle', 'Daftar log aktivitas penting dari admin, kontributor, dan pengguna.')

@section('content')
    <div class="space-y-8">
        <section class="rounded-[48px] bg-white p-8 shadow-lg">
            <h2 class="text-lg font-semibold text-blue-900">Timeline Aktivitas</h2>
            <p class="mt-1 text-sm text-slate-500">Aktivitas terbaru yang tercatat dalam platform Nol Karbon.</p>

            <div class="mt-6 space-y-4">
                @forelse ($activities as $activity)
                    <article class="rounded-3xl border border-blue-100 bg-[#f7f5f0] px-5 py-4 text-sm text-blue-900">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold">{{ ucfirst(str_replace('_', ' ', $activity->activity_type)) }}</p>
                                <p class="text-xs text-slate-500">{{ optional($activity->occurred_at)->diffForHumans() ?? $activity->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-xs text-slate-500">
                                <span class="block">Pengguna: {{ $activity->user->name ?? '-' }}</span>
                                @if($activity->performedBy)
                                    <span class="block">Dilakukan oleh: {{ $activity->performedBy->name }}</span>
                                @endif
                            </div>
                        </div>
                        @if ($activity->description)
                            <p class="mt-3 text-slate-600">{{ $activity->description }}</p>
                        @endif
                        @if (!empty($activity->metadata))
                            <div class="mt-3 rounded-2xl bg-white px-4 py-3 text-xs text-slate-500">
                                @foreach ($activity->metadata as $key => $value)
                                    <p><span class="font-semibold text-blue-800">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span> {{ is_array($value) ? implode(', ', $value) : $value }}</p>
                                @endforeach
                            </div>
                        @endif
                    </article>
                @empty
                    <p class="rounded-3xl border border-dashed border-blue-200 bg-white px-5 py-6 text-center text-sm text-blue-600">Belum ada aktivitas tercatat.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $activities->links() }}
            </div>
        </section>
    </div>
@endsection
