@extends('layouts.app')
@section('title','Dashboard Kurir')
@section('page-title','Dashboard Kurir')
@section('content')
<div class="mb-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
            <i class="fas fa-motorcycle text-2xl"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold">Halo, {{auth()->user()->name}}!</h2>
            <p class="text-blue-100 text-sm">{{$courier->courier_code}} • {{ucfirst($courier->vehicle_type)}} {{$courier->vehicle_plate}}</p>
        </div>
    </div>
</div>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-calendar-day text-blue-500"></i></div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['today_deliveries']}}</p>
        <p class="text-xs text-slate-500 mt-1">Pengiriman Hari Ini</p>
    </div>
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-box text-yellow-500"></i></div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['pending']}}</p>
        <p class="text-xs text-slate-500 mt-1">Siap Pickup</p>
    </div>
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-sky-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-truck text-sky-500"></i></div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['in_transit']}}</p>
        <p class="text-xs text-slate-500 mt-1">Dalam Perjalanan</p>
    </div>
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-check-circle text-green-500"></i></div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['delivered']}}</p>
        <p class="text-xs text-slate-500 mt-1">Selesai</p>
    </div>
</div>
<div class="card p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-slate-800">Pengiriman Terbaru</h3>
        <a href="{{route('courier.orders.index')}}" class="text-sm text-blue-500 hover:text-blue-700">Lihat Semua →</a>
    </div>
    <div class="space-y-3">
        @forelse($recent_orders as $o)
        <a href="{{route('courier.orders.show',$o)}}" class="flex items-center justify-between p-4 bg-blue-50/60 hover:bg-blue-100/60 rounded-xl transition">
            <div>
                <p class="text-sm font-semibold text-blue-700">{{$o->resi_number}}</p>
                <p class="text-xs text-slate-500">{{$o->receiver_name}} • {{$o->receiver_city}}</p>
            </div>
            <span class="badge-{{$o->current_status}} px-2.5 py-1 rounded-full text-xs font-semibold">{{$o->status_label}}</span>
        </a>
        @empty
        <p class="text-center text-sm text-slate-400 py-6">Belum ada pengiriman</p>
        @endforelse
    </div>
</div>
@endsection
