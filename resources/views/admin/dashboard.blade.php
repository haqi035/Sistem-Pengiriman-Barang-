@extends('layouts.app')
@section('title','Dashboard Admin')
@section('page-title','Dashboard Admin')
@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-clipboard-list text-blue-500"></i>
            </div>
            <span class="text-xs text-blue-400 font-medium bg-blue-50 px-2 py-1 rounded-lg">Total</span>
        </div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['total_orders']}}</p>
        <p class="text-xs text-slate-500 mt-1">Total Order</p>
    </div>
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-yellow-500"></i>
            </div>
            <span class="text-xs text-yellow-600 font-medium bg-yellow-50 px-2 py-1 rounded-lg">Pending</span>
        </div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['pending_orders']}}</p>
        <p class="text-xs text-slate-500 mt-1">Menunggu Proses</p>
    </div>
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-sky-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-truck text-sky-500"></i>
            </div>
            <span class="text-xs text-sky-600 font-medium bg-sky-50 px-2 py-1 rounded-lg">Transit</span>
        </div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['transit_orders']}}</p>
        <p class="text-xs text-slate-500 mt-1">Dalam Perjalanan</p>
    </div>
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-500"></i>
            </div>
            <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-lg">Selesai</span>
        </div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['delivered_orders']}}</p>
        <p class="text-xs text-slate-500 mt-1">Terkirim</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-day text-purple-500"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['today_orders']}}</p>
        <p class="text-xs text-slate-500 mt-1">Order Hari Ini</p>
    </div>
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-emerald-500"></i>
            </div>
        </div>
        <p class="text-xl font-bold text-blue-900">Rp {{number_format($stats['today_revenue'],0,',','.')}}</p>
        <p class="text-xs text-slate-500 mt-1">Pendapatan Hari Ini</p>
    </div>
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-indigo-500"></i>
            </div>
        </div>
        <p class="text-xl font-bold text-blue-900">Rp {{number_format($stats['month_revenue'],0,',','.')}}</p>
        <p class="text-xs text-slate-500 mt-1">Pendapatan Bulan Ini</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Chart --}}
    <div class="lg:col-span-2 card p-6">
        <h3 class="font-semibold text-slate-800 mb-4">Order 7 Hari Terakhir</h3>
        <canvas id="orderChart" height="100"></canvas>
    </div>
    {{-- Quick Stats --}}
    <div class="card p-6">
        <h3 class="font-semibold text-slate-800 mb-4">Statistik</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                <div class="flex items-center gap-3">
                    <i class="fas fa-users text-blue-500"></i>
                    <span class="text-sm font-medium text-slate-700">Total Pelanggan</span>
                </div>
                <span class="text-sm font-bold text-blue-900">{{$stats['total_customers']}}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                <div class="flex items-center gap-3">
                    <i class="fas fa-motorcycle text-blue-500"></i>
                    <span class="text-sm font-medium text-slate-700">Total Kurir</span>
                </div>
                <span class="text-sm font-bold text-blue-900">{{$stats['total_couriers']}}</span>
            </div>
        </div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="card p-6 mt-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-slate-800">Order Terbaru</h3>
        <a href="{{route('admin.orders.index')}}" class="text-sm text-blue-500 hover:text-blue-700 font-medium">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    <th class="pb-3">Resi</th><th class="pb-3">Pengirim</th><th class="pb-3">Tujuan</th>
                    <th class="pb-3">Biaya</th><th class="pb-3">Status</th><th class="pb-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-50">
                @forelse($recent_orders as $o)
                <tr class="hover:bg-blue-50/50 transition">
                    <td class="py-3 pr-4">
                        <a href="{{route('admin.orders.show',$o)}}" class="text-sm font-medium text-blue-600 hover:text-blue-800">{{$o->resi_number}}</a>
                    </td>
                    <td class="py-3 pr-4 text-sm text-slate-700">{{$o->sender_name}}</td>
                    <td class="py-3 pr-4 text-sm text-slate-500">{{$o->destinationZone->city ?? '-'}}</td>
                    <td class="py-3 pr-4 text-sm font-medium text-slate-700">Rp {{number_format($o->total_cost,0,',','.')}}</td>
                    <td class="py-3 pr-4">
                        <span class="badge-{{$o->current_status}} px-2.5 py-1 rounded-full text-xs font-semibold">{{$o->status_label}}</span>
                    </td>
                    <td class="py-3 text-xs text-slate-400">{{$o->created_at->format('d M Y')}}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-8 text-center text-slate-400 text-sm">Belum ada order</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
const d = @json($chart_data);
const labels = d.map(x=>x.date);
const totals = d.map(x=>x.total);
new Chart(document.getElementById('orderChart'), {
    type:'line',
    data:{
        labels,
        datasets:[{
            label:'Jumlah Order',
            data:totals,
            borderColor:'#3b82f6',
            backgroundColor:'rgba(59,130,246,.08)',
            fill:true,
            tension:.4,
            pointBackgroundColor:'#3b82f6',
            pointRadius:4
        }]
    },
    options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:'rgba(59,130,246,.06)'}},x:{grid:{display:false}}}}
});
</script>
@endsection
