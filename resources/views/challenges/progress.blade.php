@extends('layouts.challenge')

@section('title', 'Update Progres ' . $challenge->title)

@section('back-link')
    <a href="{{ route('challenges.show', $challenge) }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white px-4 py-2 text-xs font-semibold text-blue-900 shadow hover:bg-blue-50">
        <i class="fa-solid fa-arrow-left-long"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="mx-auto max-w-4xl space-y-8">
        <section class="rounded-[48px] border border-blue-200 bg-white p-10 shadow-lg">
            <div class="rounded-[32px] bg-blue-800 px-6 py-3 text-center text-sm font-semibold uppercase tracking-[0.4em] text-white">
                Update Progress
            </div>

            <form method="POST" action="{{ route('challenges.progress.store', $challenge) }}" class="mt-8 space-y-8">
                @csrf
                <div class="grid gap-6 md:grid-cols-2">
                    <label class="flex flex-col gap-2 rounded-[30px] border border-blue-200 bg-[#f7f5f0] px-6 py-4 text-sm text-blue-900 shadow-inner">
                        <span class="text-xs font-semibold uppercase text-blue-600">Activity</span>
                        <input type="text" value="{{ $challenge->title }}" disabled class="w-full rounded-full border border-blue-200 bg-white px-4 py-2 text-sm">
                    </label>
                    <label class="flex flex-col gap-2 rounded-[30px] border border-blue-200 bg-[#f7f5f0] px-6 py-4 text-sm text-blue-900 shadow-inner">
                        <span class="text-xs font-semibold uppercase text-blue-600">Date</span>
                        <input id="logged_for" name="logged_for" type="date" value="{{ old('logged_for', now()->toDateString()) }}" required
                               class="w-full rounded-full border border-blue-200 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        @error('logged_for') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </label>
                </div>

                <div class="rounded-[32px] border border-blue-200 bg-[#f7f5f0] p-6 text-sm text-blue-900 shadow-inner">
                    <label class="text-xs font-semibold uppercase text-blue-600" for="activity_type">Jenis Aktivitas*</label>
                    <select id="activity_type" name="activity_type" required
                            class="mt-3 w-full rounded-full border border-blue-200 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        @foreach (['submission' => 'Pengumpulan Bukti', 'check_in' => 'Check In Harian', 'milestone' => 'Pencapaian', 'adjustment' => 'Penyesuaian Target'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('activity_type') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('activity_type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <label class="flex flex-col gap-3 rounded-[32px] border border-blue-200 bg-white p-6 text-sm text-blue-900 shadow-lg">
                    <span class="text-xs font-semibold uppercase text-blue-600">Deskripsi Aktivitas*</span>
                    <textarea id="description" name="description" rows="4" required
                              class="rounded-3xl border border-blue-200 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                              placeholder="Ceritakan aktivitas ramah lingkungan yang kamu lakukan.">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </label>

        <div class="grid gap-6 md:grid-cols-2">
            <label class="flex flex-col gap-2 rounded-[30px] border border-blue-200 bg-white p-6 text-sm text-blue-900 shadow-lg">
                <span class="text-xs font-semibold uppercase text-blue-600">Nilai Progres</span>
                <input id="metric_value" name="metric_value" type="number" step="any" value="{{ old('metric_value') }}"
                       class="rounded-full border border-blue-200 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                       placeholder="Contoh: 3">
                @error('metric_value') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </label>
            <label class="flex flex-col gap-2 rounded-[30px] border border-blue-200 bg-white p-6 text-sm text-blue-900 shadow-lg">
                <span class="text-xs font-semibold uppercase text-blue-600">Satuan</span>
                <input id="metric_unit" name="metric_unit" type="text" value="{{ old('metric_unit') }}"
                       class="rounded-full border border-blue-200 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                       placeholder="kg CO₂, km, kegiatan, dll">
                @error('metric_unit') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </label>
        </div>

        <label class="flex flex-col gap-2 rounded-[30px] border border-blue-200 bg-white p-6 text-sm text-blue-900 shadow-lg">
            <span class="text-xs font-semibold uppercase text-blue-600">Update Persentase Progres</span>
            <input id="progress_percentage" name="progress_percentage" type="number" min="0" max="100" step="1"
                   value="{{ old('progress_percentage', round($participant->progress_percentage)) }}"
                   class="rounded-full border border-blue-200 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
            <span class="text-xs text-slate-500">Opsional. Biarkan kosong bila tidak ada perubahan.</span>
            @error('progress_percentage') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </label>

        <div class="rounded-[32px] border border-blue-200 bg-white p-6 text-sm text-blue-900 shadow-lg">
            <span class="text-xs font-semibold uppercase text-blue-600">Lampiran Bukti (URL)</span>
            <div class="mt-3 space-y-3">
                @for ($i = 0; $i < 3; $i++)
                    <input name="attachments[]" type="url" value="{{ old('attachments.' . $i) }}"
                           class="w-full rounded-full border border-blue-200 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                           placeholder="https://link-documentasi.com/bukti">
                @endfor
            </div>
            @error('attachments') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            @error('attachments.*') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

                <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                    <button type="submit"
                            class="inline-flex w-48 items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                        <i class="fa-solid fa-upload"></i> Simpan Laporan
                    </button>
                    <a href="{{ route('challenges.dashboard') }}"
                       class="inline-flex w-48 items-center justify-center gap-2 rounded-full border border-blue-200 px-6 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-50">
                        Batal
                    </a>
                </div>
            </form>
        </section>
    </div>
@endsection
