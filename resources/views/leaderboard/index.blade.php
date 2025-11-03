<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peringkat Kampus Hijau - Nol Karbon</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#e7ddcd] font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen flex-col">
        <header class="border-b border-white/40 bg-[#f5ede2]/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-5">
                <a href="{{ url()->previous() === url()->current() ? url('/') : url()->previous() }}"
                   class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow hover:bg-blue-50">
                    <i class="fa-solid fa-arrow-left-long text-xs"></i>
                    Back
                </a>
                <nav class="flex items-center gap-8 text-sm font-semibold text-blue-900">
                    <span class="inline-flex items-center gap-2 text-lg font-bold text-blue-900">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#041c74] text-sm font-semibold text-white shadow-md">NK</span>
                        Nol Karbon
                    </span>
                    <a href="#" class="hover:text-blue-600">Kalkulator</a>
                    <a href="#" class="hover:text-blue-600">Kartu Emisi</a>
                    <a href="{{ route('challenges.index') }}" class="hover:text-blue-600">Challenge</a>
                    <a href="#" class="hover:text-blue-600">Artikel</a>
                </nav>
                <a href="#" class="inline-flex items-center gap-2 rounded-full border border-blue-300 bg-white px-5 py-2 text-sm font-semibold text-blue-900 shadow hover:bg-blue-50">
                    Login
                </a>
            </div>
        </header>

        <main class="flex-1">
            <section class="mx-auto w-full max-w-5xl px-6 py-16 text-center">
                <h1 class="text-3xl font-semibold text-blue-900 sm:text-4xl">See your university’s score and rank in the spirit of healthy competition!</h1>
                <p class="mx-auto mt-4 max-w-2xl text-sm text-slate-600">
                    Saksikan kontribusi kampus dan komunitasmu dalam menurunkan emisi karbon. Teruskan aksi hijau dan naikkan peringkat di leaderboard Nol Karbon!
                </p>
            </section>

            <section class="mx-auto w-full max-w-5xl px-6 pb-16">
                <div class="rounded-[48px] border border-blue-200 bg-white p-6 shadow-2xl">
                    <div class="space-y-5">
                        @forelse ($leaderboard as $row)
                            <article class="flex items-center gap-4 rounded-[36px] border border-blue-200 bg-gradient-to-r from-[#d6dcff] to-[#eef0ff] px-5 py-4 shadow-inner sm:gap-6 sm:px-8 sm:py-6">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#0a1d7a] shadow-lg sm:h-16 sm:w-16">
                                    <i class="fa-solid fa-medal text-xl text-yellow-300 sm:text-2xl"></i>
                                </div>
                                <div class="flex-1 text-left">
                                    <p class="text-sm font-semibold text-blue-900 sm:text-base">
                                        {{ $row['rank'] }}. {{ $row['name'] }}
                                    </p>
                                    <p class="text-xs text-slate-600 sm:text-sm">Emisi {{ number_format($row['emission'], 1) }} Kg CO₂</p>
                                </div>
                                <div class="w-24 text-right text-base font-semibold text-blue-900 sm:w-28 sm:text-xl">
                                    {{ $row['score'] }}%
                                </div>
                                <div class="hidden h-2.5 w-24 rounded-full bg-blue-200 sm:block">
                                    <div class="h-full rounded-full bg-[#0a1d7a]" style="width: {{ min($row['score'], 100) }}%;"></div>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-3xl border border-dashed border-blue-200 bg-white px-6 py-12 text-center text-sm text-blue-700">
                                Belum ada data komunitas untuk ditampilkan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-[#041c74] py-8 text-sm text-blue-100">
            <div class="mx-auto flex max-w-5xl flex-col items-center justify-between gap-3 px-6 sm:flex-row">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white text-xl font-semibold text-[#041c74]">NK</span>
                    <div>
                        <p class="text-sm font-semibold text-white">Nol Karbon</p>
                        <p class="text-[11px] uppercase tracking-[0.3em] text-blue-200">Contact Us</p>
                    </div>
                </div>
                <p>hello@nolkarbon.id</p>
            </div>
        </footer>
    </div>
</body>
</html>
