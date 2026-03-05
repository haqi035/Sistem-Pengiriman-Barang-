<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','ShipEasy') - Sistem Pengiriman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body{font-family:'Plus Jakarta Sans',sans-serif;background:#f0f6ff;}
        .sidebar-link{transition:all .2s;}
        .sidebar-link:hover,.sidebar-link.active{background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;box-shadow:0 4px 15px rgba(59,130,246,.35);}
        .sidebar-link:hover *,.sidebar-link.active *{color:#fff!important;}
        .card{background:#fff;border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 20px rgba(59,130,246,.06);}
        .badge-pending{background:#fef3c7;color:#d97706;}
        .badge-pickup{background:#dbeafe;color:#2563eb;}
        .badge-transit,.badge-in_transit{background:#e0f2fe;color:#0284c7;}
        .badge-delivered{background:#dcfce7;color:#16a34a;}
        .badge-cancelled{background:#fee2e2;color:#dc2626;}
        .btn-primary{background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;padding:.625rem 1.25rem;border-radius:.75rem;font-weight:600;font-size:.875rem;transition:all .2s;box-shadow:0 4px 12px rgba(59,130,246,.3);}
        .btn-primary:hover{background:linear-gradient(135deg,#2563eb,#1d4ed8);box-shadow:0 6px 16px rgba(59,130,246,.4);}
        .btn-secondary{background:#f0f4ff;color:#3b82f6;padding:.625rem 1.25rem;border-radius:.75rem;font-weight:600;font-size:.875rem;transition:all .2s;}
        .btn-danger{background:#fee2e2;color:#dc2626;padding:.625rem 1.25rem;border-radius:.75rem;font-weight:600;font-size:.875rem;transition:all .2s;}
        .form-input{width:100%;padding:.625rem 1rem;border:1px solid #bfdbfe;border-radius:.75rem;font-size:.875rem;background:#f8fbff;transition:all .2s;}
        .form-input:focus{outline:none;border-color:#93c5fd;box-shadow:0 0 0 3px rgba(147,197,253,.3);}
        ::-webkit-scrollbar{width:5px;}
        ::-webkit-scrollbar-thumb{background:#93c5fd;border-radius:10px;}
    </style>
    @yield('styles')
</head>
<body>
<div x-data="{mobileOpen: false, desktopOpen: true}" class="flex h-screen overflow-hidden">

    {{-- OVERLAY MOBILE --}}
    <div x-show="mobileOpen"
         @click="mobileOpen=false"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-40 md:hidden"
         style="display:none;">
    </div>

    {{-- SIDEBAR --}}
    <aside :class="mobileOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
           :style="'width:' + (desktopOpen ? '256px' : '72px')"
           class="fixed md:relative z-50 md:z-auto h-full flex flex-col bg-white border-r border-blue-50 transition-all duration-300 shadow-sm flex-shrink-0 w-72 md:w-auto"
           style="width:256px;">

        {{-- Logo --}}
        <div class="flex items-center h-16 px-4 border-b border-blue-50 flex-shrink-0">
            <div class="flex items-center gap-3 flex-1">
                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                    <i class="fas fa-shipping-fast text-white text-sm"></i>
                </div>
                <span x-show="desktopOpen || mobileOpen" class="font-bold text-blue-900 text-lg whitespace-nowrap">ShipEasy</span>
            </div>
            {{-- Tombol close mobile --}}
            <button @click="mobileOpen=false" class="md:hidden text-slate-400 hover:text-slate-600 p-1 ml-auto">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-1">
            @php $r = auth()->user()->role; @endphp
            @if($r==='admin')
            <p x-show="desktopOpen || mobileOpen" class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">Utama</p>
            <a href="{{route('admin.dashboard')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('admin.dashboard')?'active':'text-slate-600'}}">
                <i class="fas fa-tachometer-alt w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Dashboard</span>
            </a>
            <a href="{{route('admin.orders.index')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('admin.orders*')?'active':'text-slate-600'}}">
                <i class="fas fa-clipboard-list w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Kelola Order</span>
            </a>
            <a href="{{route('admin.customers.index')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('admin.customers*')?'active':'text-slate-600'}}">
                <i class="fas fa-users w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Pelanggan</span>
            </a>
            <a href="{{route('admin.couriers.index')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('admin.couriers*')?'active':'text-slate-600'}}">
                <i class="fas fa-motorcycle w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Kurir</span>
            </a>
            <p x-show="desktopOpen || mobileOpen" class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mt-4 mb-2">Master</p>
            <a href="{{route('admin.zones.index')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('admin.zones*')?'active':'text-slate-600'}}">
                <i class="fas fa-map-marker-alt w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Zona Wilayah</span>
            </a>
            <a href="{{route('admin.rates.index')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('admin.rates*')?'active':'text-slate-600'}}">
                <i class="fas fa-tags w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Tarif</span>
            </a>
            <a href="{{route('admin.reports.index')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('admin.reports*')?'active':'text-slate-600'}}">
                <i class="fas fa-chart-bar w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Laporan</span>
            </a>
            @elseif($r==='courier')
            <a href="{{route('courier.dashboard')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('courier.dashboard')?'active':'text-slate-600'}}">
                <i class="fas fa-tachometer-alt w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Dashboard</span>
            </a>
            <a href="{{route('courier.orders.index')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('courier.orders*')?'active':'text-slate-600'}}">
                <i class="fas fa-box w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Pengiriman Saya</span>
            </a>
            @elseif($r==='customer')
            <a href="{{route('customer.dashboard')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('customer.dashboard')?'active':'text-slate-600'}}">
                <i class="fas fa-tachometer-alt w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Dashboard</span>
            </a>
            <a href="{{route('customer.orders.create')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('customer.orders.create')?'active':'text-slate-600'}}">
                <i class="fas fa-plus-circle w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Kirim Paket</span>
            </a>
            <a href="{{route('customer.orders.index')}}" @click="mobileOpen=false" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{request()->routeIs('customer.orders.index')?'active':'text-slate-600'}}">
                <i class="fas fa-history w-5 text-center text-blue-400 flex-shrink-0"></i>
                <span x-show="desktopOpen || mobileOpen" class="text-sm font-medium">Riwayat Order</span>
            </a>
            @endif
        </nav>

        {{-- Toggle desktop --}}
        <div class="p-4 border-t border-blue-50 hidden md:block">
            <button @click="desktopOpen=!desktopOpen" class="w-full flex items-center justify-center py-2 rounded-xl hover:bg-blue-50 text-slate-400 transition">
                <i :class="desktopOpen?'fa-chevron-left':'fa-chevron-right'" class="fas text-xs"></i>
            </button>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
        <header class="bg-white border-b border-blue-50 h-16 flex items-center justify-between px-4 md:px-6 shadow-sm flex-shrink-0">
            <div class="flex items-center gap-3">
                {{-- Tombol hamburger HANYA di mobile --}}
                <button @click="mobileOpen=true" class="md:hidden w-9 h-9 flex items-center justify-center rounded-xl hover:bg-blue-50 text-slate-500 transition">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <h1 class="text-sm md:text-base font-semibold text-blue-900 truncate">@yield('page-title','Dashboard')</h1>
            </div>
            <div x-data="{drop:false}" class="relative flex-shrink-0">
                <button @click="drop=!drop" class="flex items-center gap-2 md:gap-3 hover:bg-blue-50 rounded-xl px-2 md:px-3 py-2 transition">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-xs font-bold">{{strtoupper(substr(auth()->user()->name,0,2))}}</span>
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium text-slate-700 whitespace-nowrap">{{auth()->user()->name}}</p>
                        <p class="text-xs text-blue-400 capitalize">{{auth()->user()->role}}</p>
                    </div>
                    <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                </button>
                <div x-show="drop" @click.away="drop=false" x-transition
                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-blue-50 py-1 z-50"
                     style="display:none;">
                    <div class="px-4 py-2 border-b border-blue-50">
                        <p class="text-sm font-medium text-slate-700 truncate">{{auth()->user()->name}}</p>
                        <p class="text-xs text-slate-400 truncate">{{auth()->user()->email}}</p>
                    </div>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 md:p-6">
            @if(session('success'))
            <div x-data="{s:true}" x-show="s" x-init="setTimeout(()=>s=false,4000)" class="mb-4 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
                <i class="fas fa-check-circle"></i><span>{{session('success')}}</span>
            </div>
            @endif
            @if(session('error'))
            <div x-data="{s:true}" x-show="s" x-init="setTimeout(()=>s=false,4000)" class="mb-4 flex items-center gap-2 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-medium">
                <i class="fas fa-exclamation-circle"></i><span>{{session('error')}}</span>
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
@yield('scripts')
</body>
</html>