@extends('layouts.dashboard')

@section('title', 'Buat Tantangan Baru')
@section('page-title', 'Tambah Tantangan')
@section('page-subtitle', 'Rancang tantangan baru untuk mendorong aksi ramah lingkungan.')

@section('content')
    <div class="space-y-6">
        <a href="{{ route('admin.challenges.index') }}"
           class="inline-flex items-center gap-2 rounded-full border border-blue-200 px-4 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-50">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke daftar
        </a>

        <section class="rounded-[48px] bg-[#e7ddcd] p-10 shadow-lg">
            <div class="rounded-[32px] border-2 border-white bg-white/80 px-6 py-4 text-center font-semibold uppercase tracking-[0.4em] text-blue-800">
                Create a Challenge
            </div>
            <form method="POST" action="{{ route('admin.challenges.store') }}" class="mt-8 space-y-10" enctype="multipart/form-data">
                @csrf
                @include('admin.challenges._form')
            </form>
        </section>
    </div>
@endsection
