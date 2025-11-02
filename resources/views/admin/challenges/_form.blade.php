@php
    use Illuminate\Support\Facades\Storage;

    $isEdit = isset($challenge);
    $statusOptions = ['draft' => 'Draft', 'upcoming' => 'Mendatang', 'active' => 'Aktif', 'completed' => 'Selesai', 'archived' => 'Arsip'];
    $visibilityOptions = ['public' => 'Publik', 'private' => 'Private'];
@endphp

<div class="space-y-8">
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-[32px] border border-blue-200 bg-white p-6 shadow-md">
            <h3 class="rounded-full bg-blue-800 px-5 py-2 text-sm font-semibold uppercase tracking-wider text-white">Title</h3>
            <div class="mt-5 space-y-4 text-sm">
                <div>
                    <label for="title" class="font-semibold text-blue-900">Judul Tantangan*</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $challenge->title ?? '') }}" required
                           class="mt-2 w-full rounded-full border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="slug" class="font-semibold text-blue-900">Slug</label>
                    <input id="slug" name="slug" type="text" value="{{ old('slug', $challenge->slug ?? '') }}"
                           class="mt-2 w-full rounded-full border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                           placeholder="otomatis bila dikosongkan">
                    @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="rounded-[32px] border border-blue-200 bg-white p-6 shadow-md">
            <h3 class="rounded-full bg-blue-800 px-5 py-2 text-sm font-semibold uppercase tracking-wider text-white">Picture</h3>
            <div class="mt-5 space-y-4 text-sm">
                <div>
                    <label for="cover_image" class="font-semibold text-blue-900">Cover Image</label>
                    <input id="cover_image" name="cover_image" type="file"
                           class="mt-2 w-full rounded-full border border-blue-200 px-5 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                           accept="image/*">
                    @error('cover_image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="rounded-3xl border border-dashed border-blue-200 bg-blue-50/60 px-5 py-6 text-center text-xs text-blue-700">
                    <p>Pratinjau otomatis setelah menyimpan.</p>
                    @php
                        $previewPath = $challenge->cover_image_path ?? null;
                    @endphp
                    @if ($previewPath)
                        @php
                            $previewUrl = match (true) {
                                Storage::disk('public')->exists($previewPath) => Storage::url($previewPath),
                                filter_var($previewPath, FILTER_VALIDATE_URL) => $previewPath,
                                default => 'https://images.unsplash.com/photo-1523978591478-c753949ff840?auto=format&fit=crop&w=340&q=80',
                            };
                        @endphp
                        <img src="{{ $previewUrl }}" alt="Preview"
                             class="mx-auto mt-4 h-28 w-28 rounded-2xl object-cover shadow-inner">
                    @endif
                </div>
            </div>
        </div>

        <div class="rounded-[32px] border border-blue-200 bg-white p-6 shadow-md lg:col-span-1">
            <h3 class="rounded-full bg-blue-800 px-5 py-2 text-sm font-semibold uppercase tracking-wider text-white">Description</h3>
            <div class="mt-5 space-y-4 text-sm">
                <div>
                    <label for="description" class="font-semibold text-blue-900">Deskripsi</label>
                    <textarea id="description" name="description" rows="5"
                              class="mt-2 w-full rounded-3xl border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                              placeholder="Ceritakan tujuan dan dampak tantangan">{{ old('description', $challenge->description ?? '') }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="instructions" class="font-semibold text-blue-900">Instruksi Peserta</label>
                    <textarea id="instructions" name="instructions" rows="4"
                              class="mt-2 w-full rounded-3xl border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                              placeholder="Langkah-langkah, cara melapor, dsb.">{{ old('instructions', $challenge->instructions ?? '') }}</textarea>
                    @error('instructions') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="requirements" class="font-semibold text-blue-900">Requirement (pisahkan baris)</label>
                    <textarea id="requirements" name="requirements" rows="3"
                              class="mt-2 w-full rounded-3xl border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                              placeholder="Contoh:
- Upload bukti foto mingguan
- Catat pengurangan emisi">{{ old('requirements', isset($challenge->requirements) ? implode("\n", $challenge->requirements) : '') }}</textarea>
                    @error('requirements') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="rounded-[32px] border border-blue-200 bg-white p-6 shadow-md">
            <h3 class="rounded-full bg-blue-800 px-5 py-2 text-sm font-semibold uppercase tracking-wider text-white">Duration & Reward</h3>
            <div class="mt-5 space-y-4 text-sm">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="start_date" class="font-semibold text-blue-900">Mulai</label>
                        <input id="start_date" name="start_date" type="date" value="{{ old('start_date', optional($challenge->start_date ?? null)->toDateString()) }}"
                               class="mt-2 w-full rounded-full border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        @error('start_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="end_date" class="font-semibold text-blue-900">Berakhir</label>
                        <input id="end_date" name="end_date" type="date" value="{{ old('end_date', optional($challenge->end_date ?? null)->toDateString()) }}"
                               class="mt-2 w-full rounded-full border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        @error('end_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="point_reward" class="font-semibold text-blue-900">Poin Reward*</label>
                        <input id="point_reward" name="point_reward" type="number" min="0" value="{{ old('point_reward', $challenge->point_reward ?? 0) }}" required
                               class="mt-2 w-full rounded-full border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        @error('point_reward') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="bonus_point" class="font-semibold text-blue-900">Bonus Poin</label>
                        <input id="bonus_point" name="bonus_point" type="number" min="0" value="{{ old('bonus_point', $challenge->bonus_point ?? 0) }}"
                               class="mt-2 w-full rounded-full border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        @error('bonus_point') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="max_participants" class="font-semibold text-blue-900">Kuota Peserta</label>
                        <input id="max_participants" name="max_participants" type="number" min="1" value="{{ old('max_participants', $challenge->max_participants ?? '') }}"
                               class="mt-2 w-full rounded-full border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                               placeholder="Kosongkan jika tidak dibatasi">
                        @error('max_participants') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="visibility" class="font-semibold text-blue-900">Visibilitas</label>
                        <select id="visibility" name="visibility" required
                                class="mt-2 w-full rounded-full border border-blue-200 px-5 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            @foreach ($visibilityOptions as $value => $label)
                                <option value="{{ $value }}" @selected(old('visibility', $challenge->visibility ?? 'public') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('visibility') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <p class="font-semibold text-blue-900">Status</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($statusOptions as $value => $label)
                            <label class="inline-flex cursor-pointer items-center gap-2 rounded-full border px-4 py-2 text-xs font-semibold transition
                                {{ old('status', $challenge->status ?? 'draft') === $value ? 'border-blue-700 bg-blue-100 text-blue-700' : 'border-blue-200 text-slate-500 hover:border-blue-400' }}">
                                <input type="radio" name="status" value="{{ $value }}" class="hidden"
                                       @checked(old('status', $challenge->status ?? 'draft') === $value)>
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                    @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.challenges.index') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 px-5 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-50">
            <i class="fa-solid fa-arrow-left"></i> Batal
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-blue-800">
            <i class="fa-solid fa-floppy-disk"></i>
            {{ $isEdit ? 'Update Challenge' : 'Simpan Challenge' }}
        </button>
    </div>
</div>
