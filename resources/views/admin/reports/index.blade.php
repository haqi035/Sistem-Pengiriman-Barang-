@extends('layouts.app')
@section('title','Laporan')
@section('page-title','Laporan Pengiriman')
@section('content')
{{-- Filter --}}
<div class="card p-5 mb-6">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{$start}}" class="border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{$end}}" class="border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
        </div>
        <button type="submit" class="btn-primary">Tampilkan</button>
    </form>
</div>

{{-- Summary --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card p-5 text-center">
        <p class="text-2xl font-bold text-blue-900">{{$summary['total_orders']}}</p>
        <p class="text-xs text-slate-500 mt-1">Total Order</p>
    </div>
    <div class="card p-5 text-center">
        <p class="text-2xl font-bold text-green-600">{{$summary['delivered_orders']}}</p>
        <p class="text-xs text-slate-500 mt-1">Terkirim</p>
    </div>
    <div class="card p-5 text-center">
        <p class="text-2xl font-bold text-yellow-600">{{$summary['pending_orders']}}</p>
        <p class="text-xs text-slate-500 mt-1">Pending</p>
    </div>
    <div class="card p-5 text-center">
        <p class="text-lg font-bold text-emerald-600">Rp {{number_format($summary['total_revenue'],0,',','.')}}</p>
        <p class="text-xs text-slate-500 mt-1">Total Pendapatan</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 card p-6">
        <h3 class="font-semibold text-slate-800 mb-4">Grafik Order Harian</h3>
        <canvas id="dailyChart" height="120"></canvas>
    </div>
    <div class="card p-6">
        <h3 class="font-semibold text-slate-800 mb-4">Status Order</h3>
        <canvas id="statusChart"></canvas>
    </div>
</div>

<div class="card p-6">
    <h3 class="font-semibold text-slate-800 mb-4">Detail Order</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-50">
                <th class="pb-3 pr-4">Resi</th><th class="pb-3 pr-4">Pengirim</th><th class="pb-3 pr-4">Tujuan</th>
                <th class="pb-3 pr-4">Biaya</th><th class="pb-3 pr-4">Status</th><th class="pb-3">Tanggal</th>
            </tr></thead>
            <tbody class="divide-y divide-blue-50">
                @forelse($orders as $o)
                <tr>
                    <td class="py-3 pr-4 text-sm font-medium text-blue-600">{{$o->resi_number}}</td>
                    <td class="py-3 pr-4 text-sm text-slate-700">{{$o->sender_name}}</td>
                    <td class="py-3 pr-4 text-sm text-slate-500">{{$o->destinationZone->city??'-'}}</td>
                    <td class="py-3 pr-4 text-sm font-semibold">Rp {{number_format($o->total_cost,0,',','.')}}</td>
                    <td class="py-3 pr-4"><span class="badge-{{$o->current_status}} px-2 py-0.5 rounded-full text-xs font-semibold">{{$o->status_label}}</span></td>
                    <td class="py-3 text-xs text-slate-400">{{$o->created_at->format('d M Y')}}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-8 text-center text-slate-400 text-sm">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{$orders->links()}}</div>
</div>
@endsection
@section('scripts')
<script>
const daily = @json($daily);
new Chart(document.getElementById('dailyChart'),{type:'bar',data:{labels:daily.map(x=>x.date),datasets:[{label:'Order',data:daily.map(x=>x.total),backgroundColor:'rgba(59,130,246,.7)',borderRadius:6}]},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true},x:{grid:{display:false}}}}});
const st = @json($by_status);
const colors={'pending':'#fef3c7','pickup':'#dbeafe','in_transit':'#e0f2fe','delivered':'#dcfce7','cancelled':'#fee2e2'};
const bColors={'pending':'#d97706','pickup':'#2563eb','in_transit':'#0284c7','delivered':'#16a34a','cancelled':'#dc2626'};
new Chart(document.getElementById('statusChart'),{type:'doughnut',data:{labels:st.map(x=>x.current_status),datasets:[{data:st.map(x=>x.total),backgroundColor:st.map(x=>colors[x.current_status]||'#e2e8f0'),borderColor:st.map(x=>bColors[x.current_status]||'#94a3b8'),borderWidth:2}]},options:{plugins:{legend:{position:'bottom'}}}});
</script>
@endsection
