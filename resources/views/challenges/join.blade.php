@extends('layouts.app')

@section('title', 'Gabung ' . $challenge->title)

@section('back-link')
    <a href="{{ route('challenges.show', $challenge) }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white px-4 py-2 text-xs font-semibold text-blue-900 shadow hover:bg-blue-50">
        <i class="fa-solid fa-arrow-left-long"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="mx-auto max-w-3xl">
        <section class="rounded-[48px] border border-blue-200 bg-white p-10 text-center shadow-lg">
            <div class="rounded-[32px] bg-blue-800 px-6 py-3 text-sm font-semibold uppercase tracking-[0.4em] text-white">
                Join Challenge
            </div>
            <p class="mt-6 text-sm text-slate-600">
                Apakah kamu yakin ingin bergabung dalam tantangan <strong>{{ $challenge->title }}</strong>? Kamu akan mendapatkan
                <strong class="text-blue-700">{{ $challenge->point_reward }} poin</strong> langsung setelah bergabung.
            </p>
            <form method="POST" action="{{ route('challenges.join.store', $challenge) }}" class="mt-10 flex flex-wrap items-center justify-center gap-4">
                @csrf
                <input type="hidden" name="motivation" value="{{ old('motivation', 'Saya siap mengikuti tantangan ini.') }}">
                <input type="hidden" name="personal_goal" value="{{ old('personal_goal', 'Mengurangi jejak karbon harian.') }}">
                <input type="hidden" name="team_name" value="{{ old('team_name') }}">
                <input type="hidden" name="start_date" value="{{ old('start_date', now()->toDateString()) }}">
                <button type="submit"
                        class="inline-flex w-44 items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                    Join Now
                </button>
                <a href="{{ route('challenges.index') }}"
                   class="inline-flex w-44 items-center justify-center gap-2 rounded-full border border-blue-200 px-6 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-50">
                    Cancel
                </a>
            </form>
        </section>
    </div>
@endsection
