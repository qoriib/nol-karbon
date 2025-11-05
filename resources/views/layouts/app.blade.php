<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name', 'Nol Karbon'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#e7ddcd] font-sans text-slate-900 antialiased">
        @php
            $current = Route::currentRouteName() ?? '';
            $navLinks = [
                [
                    'label' => 'Kalkulator',
                    'route' => null,
                    'url' => '#',
                    'pattern' => 'calculator.',
                ],
                [
                    'label' => 'Challenge',
                    'route' => 'challenges.index',
                    'url' => null,
                    'pattern' => 'challenges.',
                ],
                [
                    'label' => 'Leaderboard',
                    'route' => 'leaderboard.index',
                    'url' => null,
                    'pattern' => 'leaderboard.',
                ],
                [
                    'label' => 'Komunitas',
                    'route' => 'communities.dashboard',
                    'url' => null,
                    'pattern' => 'communities.',
                ],
                [
                    'label' => 'Artikel',
                    'route' => null,
                    'url' => '#',
                    'pattern' => 'articles.',
                ],
                [
                    'label' => 'Login',
                    'route' => null,
                    'url' => '#',
                    'pattern' => 'login',
                ],
            ];
        @endphp
        <div class="flex min-h-screen flex-col">
            <header class="px-6 pt-8">
                <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-6">
                    <div class="w-32">
                        @hasSection('back-link')
                            @yield('back-link')
                        @else
                            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white px-4 py-2 text-xs font-semibold text-blue-900 shadow hover:bg-blue-50">
                                <i class="fa-solid fa-house"></i> Beranda
                            </a>
                        @endif
                    </div>
                    <div class="flex flex-1 justify-center">
                        <div class="inline-flex items-center gap-6 rounded-full border border-blue-200 bg-white px-6 py-3 shadow-lg">
                            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-900">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-900 text-sm font-semibold text-white shadow">
                                    NK
                                </span>
                                Nol Karbon
                            </a>
                            <nav class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                                @foreach ($navLinks as $link)
                                    @php
                                        $pattern = $link['pattern'];
                                        $isActive = false;

                                        if ($link['route']) {
                                            $isActive = $current === $link['route'];
                                        }

                                        if (! $isActive && $pattern) {
                                            $isActive = str_starts_with($current, $pattern);
                                        }

                                        if (! $isActive && $link['route']) {
                                            $isActive = url()->current() === route($link['route'], [], false);
                                        }

                                        if (! $isActive && $link['url'] && url()->current() === $link['url']) {
                                            $isActive = true;
                                        }
                                    @endphp
                                    @if ($link['route'])
                                        <a href="{{ route($link['route']) }}"
                                           class="rounded-full px-4 py-2 transition {{ $isActive ? 'border border-blue-700 text-blue-800 shadow-inner' : 'hover:bg-blue-50' }}">
                                            {{ $link['label'] }}
                                        </a>
                                    @else
                                        <a href="{{ $link['url'] }}"
                                           class="rounded-full px-4 py-2 transition {{ $isActive ? 'border border-blue-700 text-blue-800 shadow-inner' : 'hover:bg-blue-50' }}">
                                            {{ $link['label'] }}
                                        </a>
                                    @endif
                                @endforeach
                            </nav>
                        </div>
                    </div>
                    <div class="w-32 flex justify-end">
                        <a href="#"
                           class="inline-flex items-center gap-2 rounded-full border border-blue-700 bg-white px-4 py-2 text-xs font-semibold text-blue-700 shadow hover:bg-blue-50">
                            <i class="fa-solid fa-right-from-bracket text-sm"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </header>

            @if (View::hasSection('hero'))
                @yield('hero')
            @else
                <section class="mx-auto w-full max-w-5xl px-6 py-12 text-center">
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
                    @hasSection('subnav')
                        <div class="mt-8 flex justify-center">
                            @yield('subnav')
                        </div>
                    @endif
                </section>
            @endif

            @if (session('status'))
                <div class="mx-auto mt-8 max-w-3xl rounded-full border border-green-200 bg-green-100 px-6 py-3 text-center text-sm text-green-700 shadow">
                    {{ session('status') }}
                </div>
            @endif

            <main class="mx-auto w-full max-w-6xl flex-1 px-6 pb-16 pt-12">
                @yield('content')
            </main>

            <footer class="mt-auto bg-[#041c74] py-8">
                <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-6 text-sm text-blue-100 md:flex-row">
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
