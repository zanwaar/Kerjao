<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.4.0
* @link https://tabler.io
* Copyright 2018-2026 The Tabler Authors
* Copyright 2018-2026 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Kerjao</title>

    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <style>@import url('https://rsms.me/inter/inter.css');</style>
    @stack('styles')
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler-theme.min.js"></script>

    @php($isAdminMonitor = auth()->user()->can('task.view-all'))
    @php($isPegawaiCompactNav = auth()->user()->hasRole('pegawai'))

    <div class="page">

        {{-- NAVBAR --}}
        <header class="navbar navbar-expand-md navbar-overlap d-print-none" data-bs-theme="dark">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="{{ route('dashboard') }}" aria-label="Kerjao">
                        <span class="fw-bold fs-3 text-white">Kerjao</span>
                    </a>
                </div>

                <div class="navbar-nav flex-row order-md-last">
                    {{-- Theme toggle --}}
                    <div class="nav-item d-none d-md-flex me-2">
                        <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Mode Gelap" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454l0 .008"/></svg>
                        </a>
                        <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Mode Terang" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M8 12a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"/></svg>
                        </a>
                    </div>

                    {{-- User menu --}}
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Buka menu pengguna">
                            <span class="avatar avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ auth()->user()->name }}</div>
                                <div class="mt-1 small text-secondary">{{ auth()->user()->getRoleNames()->first() }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" data-bs-theme="light">
                            <div class="dropdown-item text-muted">
                                <small>{{ auth()->user()->email }}</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon icon-2"><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/><path d="M9 12h12l-3 -3"/><path d="M18 15l3 -3"/></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Nav menu --}}
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="navbar-nav">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M5 12l-2 0l9 -9l9 9l-2 0"/><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"/><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"/></svg>
                                </span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>

                        @if($isPegawaiCompactNav)
                        <li class="nav-item dropdown {{ request()->routeIs('program-kerja.*', 'kegiatan.*', 'task.*', 'daily-scrum.*', 'bukti-aktivitas.*', 'github-activity.*', 'wakatime-activity.*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#navbar-pegawai-menu" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M4 4h6v6h-6z"/><path d="M14 4h6v6h-6z"/><path d="M4 14h6v6h-6z"/><path d="M14 14h6v6h-6z"/></svg>
                                </span>
                                <span class="nav-link-title">Program</span>
                            </a>
                            <div class="dropdown-menu">
                                @can('program-kerja.view')
                                <a href="{{ route('program-kerja.index') }}" class="dropdown-item {{ request()->routeIs('program-kerja.*') ? 'active' : '' }}">Program Kerja</a>
                                @endcan
                                @can('kegiatan.view')
                                <a href="{{ route('kegiatan.index') }}" class="dropdown-item {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">Kegiatan</a>
                                @endcan
                                @can('task.view')
                                <a href="{{ route('task.saya') }}" class="dropdown-item {{ request()->routeIs('task.*') ? 'active' : '' }}">Task Saya</a>
                                @endcan
                                @can('daily-scrum.view')
                                <a href="{{ route('daily-scrum.index') }}" class="dropdown-item {{ request()->routeIs('daily-scrum.*') ? 'active' : '' }}">Daily Scrum</a>
                                @endcan
                                @can('bukti-aktivitas.view')
                                <a href="{{ route('bukti-aktivitas.index') }}" class="dropdown-item {{ request()->routeIs('bukti-aktivitas.*') ? 'active' : '' }}">Bukti Aktivitas</a>
                                @endcan
                                @can('github-activity.view')
                                <a href="{{ route('github-activity.index') }}" class="dropdown-item {{ request()->routeIs('github-activity.*') ? 'active' : '' }}">GitHub</a>
                                @endcan
                                @can('wakatime-activity.view')
                                <a href="{{ route('wakatime-activity.index') }}" class="dropdown-item {{ request()->routeIs('wakatime-activity.*') ? 'active' : '' }}">WakaTime</a>
                                @endcan
                            </div>
                        </li>
                        @else
                            @can('program-kerja.view')
                            <li class="nav-item {{ request()->routeIs('program-kerja.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('program-kerja.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"/></svg>
                                    </span>
                                    <span class="nav-link-title">Program Kerja</span>
                                </a>
                            </li>
                            @endcan

                            @can('kegiatan.view')
                            @unless($isAdminMonitor)
                            <li class="nav-item {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('kegiatan.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M19 11h-14"/><path d="M19 11a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2"/><path d="M19 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v2"/></svg>
                                    </span>
                                    <span class="nav-link-title">Kegiatan</span>
                                </a>
                            </li>
                            @endunless
                            @endcan

                            @can('task.view')
                            @unless($isAdminMonitor)
                            @if(auth()->user()->can('task.view-all'))
                            <li class="nav-item dropdown {{ request()->routeIs('task.*') ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#navbar-task" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"/><path d="M9 12l2 2l4 -4"/></svg>
                                    </span>
                                    <span class="nav-link-title">Task</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{ request()->routeIs('task.index') || (request()->routeIs('task.show') && !request()->routeIs('task.saya')) ? 'active' : '' }}" href="{{ route('task.index') }}">Semua Task</a>
                                    <a class="dropdown-item {{ request()->routeIs('task.saya') ? 'active' : '' }}" href="{{ route('task.saya') }}">Task Saya</a>
                                </div>
                            </li>
                            @else
                            <li class="nav-item {{ request()->routeIs('task.*') ? 'active' : '' }}">
                                <a href="{{ route('task.saya') }}" class="nav-link">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"/><path d="M9 12l2 2l4 -4"/></svg>
                                    </span>
                                    <span class="nav-link-title">Task Saya</span>
                                </a>
                            </li>
                            @endif
                            @endunless
                            @endcan

                            @can('daily-scrum.view')
                            @unless($isAdminMonitor)
                            <li class="nav-item {{ request()->routeIs('daily-scrum.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('daily-scrum.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"/><path d="M13.5 3h4.5a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-4.5"/><path d="M8 7h1"/><path d="M8 11h1"/><path d="M8 15h1"/></svg>
                                    </span>
                                    <span class="nav-link-title">Daily Scrum</span>
                                </a>
                            </li>
                            @endunless
                            @endcan

                            @can('bukti-aktivitas.view')
                            @unless($isAdminMonitor)
                            <li class="nav-item {{ request()->routeIs('bukti-aktivitas.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('bukti-aktivitas.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M15 7a2 2 0 0 1 2 2"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h14a2 2 0 0 0 2 -2v-2"/><path d="M20 7v-1a2 2 0 0 0 -2 -2h-6"/><path d="M12 12h9"/><path d="M17 7l4 -4"/></svg>
                                    </span>
                                    <span class="nav-link-title">Bukti Aktivitas</span>
                                </a>
                            </li>
                            @endunless
                            @endcan

                            @can('github-activity.view')
                            @unless($isAdminMonitor)
                            <li class="nav-item {{ request()->routeIs('github-activity.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('github-activity.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"/></svg>
                                    </span>
                                    <span class="nav-link-title">GitHub</span>
                                </a>
                            </li>
                            @endunless
                            @endcan

                            @can('wakatime-activity.view')
                            @unless($isAdminMonitor)
                            <li class="nav-item {{ request()->routeIs('wakatime-activity.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('wakatime-activity.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path d="M12 7v5l3 3"/></svg>
                                    </span>
                                    <span class="nav-link-title">WakaTime</span>
                                </a>
                            </li>
                            @endunless
                            @endcan
                        @endif

                        @can('laporan.view')
                        <li class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('laporan.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697"/><path d="M18 14v4h4"/><path d="M18 11v-4a2 2 0 0 0 -2 -2h-2"/><path d="M10 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"/><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/></svg>
                                </span>
                                <span class="nav-link-title">Laporan</span>
                            </a>
                        </li>
                        @endcan

                        @can('pegawai.view')
                        <li class="nav-item {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('pegawai.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/></svg>
                                </span>
                                <span class="nav-link-title">Pegawai</span>
                            </a>
                        </li>
                        @endcan

                        <li class="nav-item {{ request()->routeIs('panduan') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('panduan') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M12 6.253v13m0 -13c-1.168 -.773 -2.754 -1.253 -4.5 -1.253c-1.746 0 -3.332 .48 -4.5 1.253v13c1.168 -.773 2.754 -1.253 4.5 -1.253c1.746 0 3.332 .48 4.5 1.253"/><path d="M12 6.253c1.168 -.773 2.754 -1.253 4.5 -1.253c1.746 0 3.332 .48 4.5 1.253v13c-1.168 -.773 -2.754 -1.253 -4.5 -1.253c-1.746 0 -3.332 .48 -4.5 1.253"/></svg>
                                </span>
                                <span class="nav-link-title">Panduan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        {{-- END NAVBAR --}}

        <div class="page-wrapper">
            {{-- PAGE HEADER --}}
            <div class="page-header d-print-none text-white">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            @hasSection('pretitle')
                            <div class="page-pretitle">@yield('pretitle')</div>
                            @endif
                            <h2 class="page-title">@yield('title', 'Dashboard')</h2>
                        </div>
                        @hasSection('actions')
                        <div class="col-auto ms-auto d-print-none">
                            @yield('actions')
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            {{-- END PAGE HEADER --}}

            {{-- PAGE BODY --}}
            <div class="page-body">
                <div class="container-xl">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible mb-3" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon"><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path d="M9 12l2 2l4 -4"/></svg>
                            </div>
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible mb-3" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon"><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                            </div>
                            <div>{{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @yield('content')

                </div>
            </div>
            {{-- END PAGE BODY --}}

            {{-- FOOTER --}}
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; {{ date('Y') }} — Kerjao. All rights reserved.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
            {{-- END FOOTER --}}

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js" defer></script>
    @stack('scripts')
</body>
</html>
