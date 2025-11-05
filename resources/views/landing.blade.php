<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Menu Nol Karbon</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#e7ddcd] font-sans text-slate-900 antialiased">
        <main class="mx-auto flex min-h-screen w-full max-w-4xl flex-col items-center justify-center gap-10 px-6 py-16">
            <header class="text-center">
                <span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-blue-900 text-lg font-semibold text-white shadow">NK</span>
                <h1 class="mt-6 text-3xl font-semibold text-slate-900">Nol Karbon — Navigasi Cepat</h1>
                <p class="mt-2 text-sm text-slate-600">Pilih halaman yang ingin kamu buka.</p>
            </header>

            <section class="w-full space-y-4">
                <article class="rounded-3xl border border-blue-200 bg-white p-6 shadow transition hover:shadow-lg">
                    <h2 class="text-lg font-semibold text-blue-900">Area Challenge</h2>
                    <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-slate-600">
                        <li><a class="font-semibold text-blue-700 hover:underline" href="{{ route('challenges.index') }}">Beranda Challenge</a></li>
                        <li><a class="font-semibold text-blue-700 hover:underline" href="{{ route('challenges.dashboard') }}">Dashboard Progress &amp; Poin</a></li>
                        <li><a class="font-semibold text-blue-700 hover:underline" href="{{ route('challenges.badges') }}">Badge &amp; Level</a></li>
                    </ul>
                </article>

                <article class="rounded-3xl border border-blue-200 bg-white p-6 shadow transition hover:shadow-lg">
                    <h2 class="text-lg font-semibold text-blue-900">Leaderboard &amp; Komunitas</h2>
                    <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-slate-600">
                        <li><a class="font-semibold text-blue-700 hover:underline" href="{{ route('leaderboard.index') }}">Leaderboard Kampus</a></li>
                        <li><a class="font-semibold text-blue-700 hover:underline" href="{{ route('communities.dashboard') }}">Dashboard Komunitas</a></li>
                    </ul>
                </article>

                <article class="rounded-3xl border border-blue-200 bg-white p-6 shadow transition hover:shadow-lg">
                    <h2 class="text-lg font-semibold text-blue-900">Panel Admin</h2>
                    <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-slate-600">
                        <li><a class="font-semibold text-blue-700 hover:underline" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                        <li><a class="font-semibold text-blue-700 hover:underline" href="{{ route('admin.challenges.index') }}">Manajemen Challenge</a></li>
                        <li><a class="font-semibold text-blue-700 hover:underline" href="{{ route('admin.reports.index') }}">Laporan Emisi &amp; Partisipasi</a></li>
                        <li><a class="font-semibold text-blue-700 hover:underline" href="{{ route('admin.reports.activities') }}">Aktivitas Pengguna</a></li>
                    </ul>
                </article>
            </section>
        </main>
    </body>
</html>
