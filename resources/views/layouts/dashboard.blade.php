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
    <body class="min-h-screen bg-[#ede3d5] font-sans text-slate-900 antialiased">
        @php
            $navLinks = [
                [
                    'label' => 'Dashboard',
                    'route' => 'admin.dashboard',
                    'pattern' => 'admin.dashboard',
                    'icon' => 'fa-solid fa-grip',
                ],
                [
                    'label' => 'User Management',
                    'route' => null,
                    'url' => '#',
                    'pattern' => 'admin.users.',
                    'icon' => 'fa-solid fa-user-group',
                ],
                [
                    'label' => 'Communities',
                    'route' => null,
                    'url' => '#',
                    'pattern' => 'admin.communities.',
                    'icon' => 'fa-solid fa-city',
                ],
                [
                    'label' => 'Content',
                    'route' => null,
                    'url' => '#',
                    'pattern' => 'admin.content.',
                    'icon' => 'fa-solid fa-file-lines',
                ],
                [
                    'label' => 'Challenges',
                    'route' => 'admin.challenges.index',
                    'pattern' => 'admin.challenges.',
                    'icon' => 'fa-solid fa-bullseye',
                ],
                [
                    'label' => 'Reports',
                    'route' => 'admin.reports.index',
                    'pattern' => 'admin.reports',
                    'icon' => 'fa-solid fa-chart-line',
                ],
                [
                    'label' => 'Emission Card',
                    'route' => null,
                    'url' => '#',
                    'pattern' => 'admin.emission-cards.',
                    'icon' => 'fa-solid fa-id-card',
                ],
            ];
        @endphp
        <div class="flex min-h-screen">
            <aside class="hidden w-64 flex-col justify-between bg-[#041c74] px-6 py-8 text-blue-100 lg:flex">
                <div>
                    <div class="mb-10 flex items-center gap-3">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white text-xl font-semibold text-[#041c74]">
                            NK
                        </span>
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-blue-300">Nol Karbon</p>
                            <p class="text-lg font-semibold text-white">Admin Panel</p>
                        </div>
                    </div>
                    <nav class="space-y-2 text-sm font-medium">
                        @foreach ($navLinks as $link)
                            @php
                                $current = Route::currentRouteName() ?? '';
                                $pattern = $link['pattern'] ?? ($link['route'] ?? '');
                                $isActive = false;

                                if ($link['route']) {
                                    $isActive = $current === $link['route'] || ($pattern && str_starts_with($current, $pattern));
                                } elseif ($pattern) {
                                    $isActive = str_starts_with($current, $pattern);
                                }

                                $href = $link['route'] ? route($link['route']) : ($link['url'] ?? '#');
                            @endphp
                            <a href="{{ $href }}"
                               class="flex items-center gap-3 rounded-xl px-4 py-3 transition {{ $isActive ? 'bg-[#0b2db5] text-white shadow-lg' : 'hover:bg-white/10' }}">
                                <i class="{{ $link['icon'] }} text-base"></i>
                                <span>{{ $link['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>
                </div>
                <div class="space-y-6 text-xs text-blue-200">
                    <a href="#" class="inline-flex items-center gap-2 rounded-full border border-white/40 px-4 py-2 font-semibold text-blue-100 hover:bg-white/10">
                        <i class="fa-solid fa-right-from-bracket text-sm"></i>
                        Logout
                    </a>
                    <div class="flex items-center gap-2 text-blue-200">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-[#041c74] font-semibold">NK</span>
                        <div>
                            <p class="text-sm font-semibold text-white">Nol Karbon</p>
                            <p class="text-[11px] uppercase tracking-[0.3em]">Contact Us</p>
                        </div>
                    </div>
                </div>
            </aside>
            <main class="flex flex-1 flex-col">
                <header class="flex flex-col gap-6 bg-white px-8 py-6 shadow-lg sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Nol Karbon Dashboard</p>
                        <h1 class="mt-2 text-2xl font-semibold text-slate-900">
                            @yield('page-title', 'Overview')
                        </h1>
                        @hasSection('page-subtitle')
                            <p class="mt-2 text-sm text-slate-500">@yield('page-subtitle')</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 rounded-2xl border border-slate-200 px-5 py-3 text-sm">
                        <div class="text-right">
                            <p class="font-semibold text-slate-900">Miguel Alexandro</p>
                            <p class="text-xs text-slate-500">miguel@nolkarbon.id</p>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-lg font-semibold text-slate-600">
                            MA
                        </span>
                    </div>
                </header>
                <div class="flex-1 overflow-y-auto px-8 py-10">
                    @yield('content')
                </div>
                <footer class="bg-[#041c74] px-8 py-6 text-sm text-blue-100">
                    <div class="flex flex-col items-center justify-between gap-2 sm:flex-row">
                        <span>Nol Karbon © {{ now()->year }}</span>
                        <span>Contact Us • hello@nolkarbon.id</span>
                    </div>
                </footer>
            </main>
        </div>
    </body>
</html>
