<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Nol Karbon Challenge')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#e7ddcd] font-sans text-slate-900 antialiased">
        <div class="flex min-h-screen flex-col">
            <header class="mx-auto flex w-full max-w-5xl items-center justify-between px-6 pt-8 text-sm font-medium text-blue-900">
                <div>
                    @hasSection('back-link')
                        @yield('back-link')
                    @else
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white px-4 py-2 shadow hover:bg-blue-50">
                            <i class="fa-solid fa-arrow-left-long text-xs"></i>
                            Beranda
                        </a>
                    @endif
                </div>
                <div class="flex items-center gap-4">
                    @yield('top-nav')
                    <a href="#" class="inline-flex items-center gap-2 rounded-full border border-blue-300 bg-white px-4 py-2 text-xs font-semibold text-blue-900 shadow hover:bg-blue-50">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Logout
                    </a>
                </div>
            </header>

            <main class="mx-auto w-full max-w-5xl flex-1 px-6 pb-16">
                <section class="mt-12 text-center">
                    <div class="inline-flex items-center gap-3 rounded-full bg-white px-6 py-3 text-xs font-semibold uppercase tracking-[0.4em] text-blue-800 shadow">
                        Nol Karbon
                    </div>
                    <h1 class="mt-6 text-4xl font-semibold leading-tight text-slate-900">
                        Let’s Contribute and Be Part of <span class="text-blue-700">Nol Karbon</span>
                    </h1>
                    <p class="mx-auto mt-4 max-w-3xl text-sm text-slate-600">
                        Nol Karbon empowers you to take small yet meaningful actions for a cleaner, greener future. Together, we can build a world free from carbon emissions.
                    </p>
                    @hasSection('hero-actions')
                        <div class="mt-6 flex flex-wrap items-center justify-center gap-4">
                            @yield('hero-actions')
                        </div>
                    @endif
                </section>

            @if (session('status'))
                <div class="mx-auto mt-8 max-w-3xl rounded-full border border-green-200 bg-green-100 px-6 py-3 text-center text-sm text-green-700 shadow">
                    {{ session('status') }}
                </div>
            @endif

                <section class="mt-12">
                    @yield('content')
                </section>
            </main>

            <footer class="mt-auto bg-[#041c74] py-8">
                <div class="mx-auto flex max-w-5xl flex-col items-center justify-between gap-3 px-6 text-sm text-blue-100 md:flex-row">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white text-xl font-semibold text-[#041c74]">
                            NK
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-white">Nol Karbon</p>
                            <p class="text-[11px] uppercase tracking-[0.3em] text-blue-200">Digital Green Ecosystem</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 text-xs uppercase tracking-[0.3em] text-blue-200">
                        <span>Contact Us</span>
                        <span>hello@nolkarbon.id</span>
                        <span>© {{ now()->year }} Nol Karbon</span>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
