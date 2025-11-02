<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nol Karbon — Towards Cleaner Air</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9a7V6p6NccHP1+YhjCsZg6+MTc9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f7efde] font-sans text-slate-900 antialiased">
        <div class="relative">
            <div class="mx-auto max-w-6xl px-6">
                <header class="flex flex-col gap-6 py-8 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-blue-800 text-xl font-semibold text-white">
                            NK
                        </span>
                        <div>
                            <p class="text-xs uppercase tracking-widest text-blue-500">Nol Karbon</p>
                            <p class="text-base font-semibold text-blue-900">Towards Cleaner Air</p>
                        </div>
                    </div>
                    <nav class="flex flex-wrap items-center gap-4 text-sm font-medium text-slate-600">
                        <a href="#impact" class="hover:text-blue-700">Impact</a>
                        <a href="#program" class="hover:text-blue-700">Program</a>
                        <a href="#dashboard" class="hover:text-blue-700">Dashboard</a>
                        <a href="#challenge" class="hover:text-blue-700">Challenge</a>
                        <a href="#articles" class="hover:text-blue-700">Articles</a>
                        <a href="{{ route('challenges.index') }}"
                           class="inline-flex items-center rounded-full bg-blue-800 px-4 py-2 text-white shadow-sm hover:bg-blue-900">
                            Masuk Dashboard
                        </a>
                    </nav>
                </header>

                <section class="grid gap-10 rounded-3xl border border-slate-200 bg-white p-10 shadow-lg md:grid-cols-2">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-blue-500">Nol Karbon Initiative</p>
                        <h1 class="mt-5 text-4xl font-semibold leading-tight text-slate-900">
                            Towards Cleaner Air<br>
                            <span class="text-blue-700">Start From Nol Karbon</span>
                        </h1>
                        <p class="mt-4 text-sm text-slate-600">
                            Nol Karbon adalah gerakan digital untuk membantu kampus dan komunitas mengukur, melaporkan,
                            dan mengurangi emisi karbon. Bergabunglah untuk memulai langkah kecil menuju bumi yang lebih sehat.
                        </p>
                        <div class="mt-6 flex flex-wrap gap-3 text-sm">
                            <a href="{{ route('challenges.index') }}"
                               class="inline-flex items-center justify-center rounded-full bg-blue-800 px-5 py-3 font-semibold text-white hover:bg-blue-900">
                                Ikuti Tantangan
                            </a>
                            <a href="#impact"
                               class="inline-flex items-center justify-center rounded-full border border-blue-800 px-5 py-3 font-semibold text-blue-800 hover:bg-blue-50">
                                Pelajari Dampak
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between gap-6">
                        <div class="rounded-3xl bg-gradient-to-r from-blue-900 to-cyan-600 p-6 text-white shadow-2xl">
                            <p class="text-sm font-semibold">#NolKarbon</p>
                            <p class="mt-3 text-sm leading-relaxed text-blue-50">
                                “Pilihlah langkah kecil yang berarti. Mengurangi satu plastik sekali pakai, menggunakan transportasi
                                umum, dan menanam pohon adalah investasi mikro untuk masa depan planet kita.”
                            </p>
                            <footer class="mt-4 text-xs text-blue-100">Nol Karbon Story • 2025</footer>
                        </div>
                        <img src="https://images.unsplash.com/photo-1497436072909-60f360e1d4b1?auto=format&fit=crop&w=900&q=80" alt="Clean energy"
                             class="h-48 w-full rounded-3xl object-cover shadow-lg" />
                    </div>
                </section>
            </div>

            <section id="impact" class="mt-16 bg-blue-900 py-16">
                <div class="mx-auto max-w-6xl px-6">
                    <div class="text-center">
                        <p class="text-xs uppercase tracking-[0.2em] text-blue-200">Kolaborasi Hijau</p>
                        <h2 class="mt-4 text-3xl font-semibold text-white">Together, We Make a Difference</h2>
                        <p class="mt-3 text-sm text-blue-100">
                            Sign up sebagai mahasiswa, kontributor artikel, atau admin komunitas dan rasakan perbedaan nyata menuju nol emisi.
                        </p>
                    </div>
                    <div class="mt-10 grid gap-6 text-sm text-blue-100 md:grid-cols-3">
                        <article class="rounded-3xl bg-blue-800 p-6 shadow-lg">
                            <p class="text-6xl text-blue-300">“</p>
                            <p class="mt-2 leading-relaxed">
                                “Dashboard Nol Karbon memudahkan kami memantau aksi setiap fakultas. Komunitas jadi lebih kompak dan terukur!”
                            </p>
                            <p class="mt-4 text-xs uppercase tracking-widest text-blue-300">Dania • Admin Kampus</p>
                        </article>
                        <article class="rounded-3xl bg-blue-800 p-6 shadow-lg">
                            <p class="text-6xl text-blue-300">“</p>
                            <p class="mt-2 leading-relaxed">
                                “Melalui tantangan mingguan, saya berhasil mengurangi 15 kg CO₂ dalam sebulan dan dapat badge ‘Carbon Slayer’.”
                            </p>
                            <p class="mt-4 text-xs uppercase tracking-widest text-blue-300">Husna • Mahasiswa</p>
                        </article>
                        <article class="rounded-3xl bg-blue-800 p-6 shadow-lg">
                            <p class="text-6xl text-blue-300">“</p>
                            <p class="mt-2 leading-relaxed">
                                “Kontributor mendapat ruang untuk berbagi artikel edukatif. Artikel saya dibaca 5.000 mahasiswa!”
                            </p>
                            <p class="mt-4 text-xs uppercase tracking-widest text-blue-300">Alexandra • Kontributor</p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="program" class="mx-auto mt-16 max-w-6xl px-6">
                <div class="grid gap-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-lg md:grid-cols-2">
                    <div>
                        <h3 class="text-2xl font-semibold text-slate-900">Support Our Projects</h3>
                        <p class="mt-3 text-sm text-slate-600">
                            Dari edukasi hingga aksi lapangan, Nol Karbon menghadirkan proyek dengan dampak nyata:
                            manajemen sampah, efisiensi energi, hingga kampanye transportasi hijau.
                        </p>
                        <ul class="mt-5 space-y-3 text-sm text-slate-600">
                            <li class="flex items-center gap-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">1</span>
                                Eco Action Lab untuk eksperimen energi terbarukan.
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-amber-700">2</span>
                                Kampanye #ZeroPlastic di 15 kampus partner.
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-700">3</span>
                                Program Carbon Literacy untuk komunitas mahasiswa.
                            </li>
                        </ul>
                    </div>
                    <div class="grid gap-4 text-sm">
                        <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=900&q=80" alt="Forest"
                             class="h-52 w-full rounded-3xl object-cover shadow-md">
                        <div class="grid gap-4 rounded-3xl bg-slate-900 p-6 text-white md:grid-cols-2">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">SDGs Impact</p>
                                <p class="mt-2 text-sm leading-relaxed">
                                    Menghasilkan data aksi untuk SDGs 11, 12, dan 13.
                                </p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Komunitas</p>
                                <p class="mt-2 text-sm leading-relaxed">
                                    120+ komunitas aktif kolaborasi setiap bulannya.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto mt-16 max-w-6xl px-6">
                <div class="grid gap-10 rounded-3xl border border-slate-200 bg-white p-10 shadow-lg md:grid-cols-2">
                    <div>
                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80"
                             alt="Earth care" class="h-56 w-full rounded-3xl object-cover shadow-lg" />
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-2xl font-semibold text-slate-900">Let’s see how your habits affect the Earth</h3>
                        <p class="mt-3 text-sm text-slate-600">
                            Emisi karbon personal mudah diawasi melalui Nol Karbon Emission Card.
                            Catat aktivitas harian, lihat grafik pengurangan CO₂, dan dapatkan rekomendasi aksi lanjutan.
                        </p>
                        <a href="{{ route('challenges.dashboard') }}"
                           class="mt-6 inline-flex items-center justify-center rounded-full bg-blue-800 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-900">
                            Mulai Monitor
                        </a>
                    </div>
                </div>
            </section>

            <section id="dashboard" class="mt-16 bg-blue-900 py-16">
                <div class="mx-auto grid max-w-6xl gap-12 px-6 lg:grid-cols-2">
                    <div class="space-y-6 text-white">
                        <div class="rounded-3xl bg-white/10 p-6 backdrop-blur">
                            <h3 class="text-xl font-semibold text-white">Track Your Campus Emission Performance!</h3>
                            <p class="mt-3 text-sm text-blue-100">
                                Dashboard komunitas menampilkan peringkat kampus, tren emisi, dan progress challenge.
                            </p>
                            <div class="mt-5 grid gap-3 text-sm text-blue-100">
                                <div class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3">
                                    <span>1st • Universitas Brawijaya</span>
                                    <span>100.000 poin</span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3">
                                    <span>2nd • Institut Teknologi Bandung</span>
                                    <span>90.000 poin</span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl bg-white/5 px-4 py-3">
                                    <span>3rd • Universitas Indonesia</span>
                                    <span>85.000 poin</span>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-6 backdrop-blur">
                            <h3 class="text-xl font-semibold text-white">Track Your Individual Emission Performance!</h3>
                            <div class="mt-4 flex items-center justify-between text-sm text-blue-100">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=140&q=80" alt="Person"
                                         class="h-12 w-12 rounded-full object-cover">
                                    <div>
                                        <p class="font-semibold text-white">Dania Aurel</p>
                                        <p class="text-xs text-blue-200">Brawijaya University</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs uppercase text-blue-200">Emisi Harian</p>
                                    <p class="text-lg font-semibold text-white">2.4 kg CO₂</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="rounded-3xl bg-white p-6 text-slate-900 shadow-lg">
                            <h3 class="text-xl font-semibold text-slate-900">Get Your Own “Kartu Emisi”</h3>
                            <p class="mt-3 text-sm text-slate-600">
                                Lihat rangkuman aktivitas, emisi, dan penghematan energi dalam satu kartu digital.
                            </p>
                            <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm">
                                <p class="text-xs uppercase text-slate-500">Emission Card • Nol Karbon</p>
                                <p class="mt-3 text-lg font-semibold">Dania Aurel</p>
                                <p class="text-xs text-slate-500">Brawijaya University</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-xs uppercase text-slate-500">Monthly Emission</span>
                                    <span class="text-lg font-semibold text-blue-700">24.6 kg CO₂</span>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-3xl bg-white p-6 text-center text-slate-900 shadow-lg" id="challenge">
                            <h3 class="text-xl font-semibold">Join Eco Challenge and Earn Points!</h3>
                            <p class="mt-3 text-sm text-slate-600">
                                Setiap aksi positif bernilai. Kumpulkan poin, buka badge, dan menangkan leaderboard mingguan.
                            </p>
                            <img src="https://images.unsplash.com/photo-1502786129293-79981df4e689?auto=format&fit=crop&w=600&q=80"
                                 alt="Trophy" class="mx-auto mt-4 h-32 w-32 rounded-full object-cover shadow-inner" />
                            <a href="{{ route('challenges.index') }}"
                               class="mt-6 inline-flex items-center justify-center rounded-full bg-blue-800 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-900">
                                Check it Out!
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="articles" class="mx-auto mt-16 max-w-6xl px-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-lg">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Stay Informed</p>
                            <h3 class="mt-2 text-2xl font-semibold text-slate-900">
                                Climate, Carbon, and Sustainability Stories
                            </h3>
                            <p class="mt-2 text-sm text-slate-600">
                                Dapatkan update rutin dari kontributor Nol Karbon untuk inspirasikan komunitasmu.
                            </p>
                        </div>
                        <a href="{{ route('challenges.leaderboard') }}"
                           class="inline-flex items-center justify-center rounded-full bg-blue-800 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-900">
                            Lihat Leaderboard
                        </a>
                    </div>
                    <div class="mt-8 grid gap-6 md:grid-cols-3">
                        @foreach ([
                            'Zero carbon for better life start by little yourself bla bla',
                            'Energi terbarukan untuk kampus modern',
                            'Transportasi hijau mengubah gaya hidup mahasiswa',
                        ] as $title)
                            <article class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-5 text-sm text-slate-600">
                                <img src="https://images.unsplash.com/photo-1523978591478-c753949ff840?auto=format&fit=crop&w=600&q=80"
                                     alt="Forest article" class="h-40 w-full rounded-2xl object-cover shadow" />
                                <p class="text-xs uppercase text-slate-400">Climate Story</p>
                                <h4 class="text-base font-semibold text-slate-900">{{ $title }}</h4>
                                <p class="text-sm text-slate-600">
                                    Ikuti insight terbaru dari kontributor kami mengenai aksi nol karbon yang mudah dilakukan.
                                </p>
                                <a href="#" class="text-sm font-semibold text-blue-700 hover:underline">Baca Selengkapnya</a>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <footer class="mt-16 bg-blue-900 py-8">
                <div class="mx-auto flex max-w-6xl flex-col items-center gap-2 px-6 text-sm text-blue-100 md:flex-row md:justify-between">
                    <div class="flex items-center gap-3 text-blue-100">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-700 text-white font-semibold">NK</span>
                        <span>Nol Karbon • Digital Green Ecosystem</span>
                    </div>
                    <div class="flex items-center gap-4 text-xs uppercase tracking-[0.2em] text-blue-200">
                        <span>Contact Us</span>
                        <span>hello@nolkarbon.id</span>
                        <span>© {{ now()->year }} Nol Karbon</span>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
