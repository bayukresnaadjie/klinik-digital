<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Klinik Digital — @yield('title','Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 font-sans antialiased">

<div class="flex min-h-screen">
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed inset-y-0 left-0 z-30">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
            <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div>
                <div class="font-bold text-gray-900 text-sm">Klinik Digital</div>
                <div class="text-xs text-gray-400">Sistem Informasi Klinik</div>
            </div>
        </div>

        <nav class="flex-1 px-3 py-3 overflow-y-auto space-y-0.5">
            @php
            $role = auth()->user()->role ?? 'admin';
            $menu = [
                ['route'=>'dashboard','label'=>'Dashboard','icon'=>'<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>'],
                ['divider'=>'PELAYANAN'],
                ['route'=>'antrian.index','label'=>'Antrian & Kunjungan','icon'=>'<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>'],
                ['route'=>'pasien.index','label'=>'Data Pasien','icon'=>'<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
                ['route'=>'resep.index','label'=>'Apotek & Resep','icon'=>'<path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/>'],
                ['route'=>'billing.index','label'=>'Kasir & Billing','icon'=>'<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>'],
                ['divider'=>'MASTER DATA'],
                ['route'=>'obat.index','label'=>'Data Obat','icon'=>'<path d="M10.5 20H4a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 0 1 1.66.9l.82 1.2a2 2 0 0 0 1.66.9H20a2 2 0 0 1 2 2v3"/>'],
                ['route'=>'dokter.index','label'=>'Data Dokter','icon'=>'<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>'],
                ['route'=>'poli.index','label'=>'Data Poli','icon'=>'<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>'],
                ['divider'=>'LAPORAN'],
                ['route'=>'laporan.kunjungan','label'=>'Lap. Kunjungan','icon'=>'<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>'],
                ['route'=>'laporan.pendapatan','label'=>'Lap. Pendapatan','icon'=>'<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>'],
            ];
            @endphp

            @foreach($menu as $item)
                @if(isset($item['divider']))
                    <div class="pt-3 pb-1 px-3"><span class="text-xs font-semibold text-gray-400 tracking-wider">{{ $item['divider'] }}</span></div>
                @else
                    @php $active = request()->routeIs(explode('.', $item['route'])[0] . '.*') || request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition {{ $active ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
        </nav>

        <div class="px-4 py-3 border-t border-gray-100">
            <div class="flex items-center gap-2 px-2 mb-2">
                <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-blue-700 font-bold text-xs">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-medium text-gray-900 truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-400 capitalize">{{ auth()->user()->role }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-2 px-3 py-1.5 text-xs text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-64">
        <header class="bg-white border-b border-gray-200 px-8 py-4 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-base font-semibold text-gray-900">@yield('title','Dashboard')</h1>
                    <p class="text-xs text-gray-400">@yield('subtitle', now()->translatedFormat('l, d F Y'))</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-400 hidden md:block">{{ now()->format('H:i') }} WIB</span>
                    @yield('header-action')
                </div>
            </div>
        </header>

        <div class="px-8 pt-4">
            @foreach(['success'=>'green','error'=>'red','info'=>'blue','warning'=>'amber'] as $type => $color)
            @if(session($type))
            <div class="bg-{{ $color }}-50 border border-{{ $color }}-200 text-{{ $color }}-700 px-4 py-3 rounded-lg text-sm mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session($type) }}
            </div>
            @endif
            @endforeach
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
                <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
        </div>

        <div class="px-8 py-5 pb-10">@yield('content')</div>
    </main>
</div>
</body>
</html>
