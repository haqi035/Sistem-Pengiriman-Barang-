@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('content')
<div class="mb-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
    <h2 class="text-xl font-bold">Halo, {{auth()->user()->name}}! 👋</h2>
    <p class="text-blue-100 text-sm mt-1">Selamat datang di ShipEasy. Kirim paket dengan mudah!</p>
    <a href="{{route('customer.orders.create')}}" class="inline-flex items-center gap-2 mt-4 bg-white text-blue-600 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-blue-50 transition shadow-lg">
        <i class="fas fa-plus"></i><span>Kirim Paket Sekarang</span>
    </a>
</div>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-boxes text-blue-500"></i></div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['total']}}</p>
        <p class="text-xs text-slate-500 mt-1">Total Order</p>
    </div>
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-clock text-yellow-500"></i></div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['pending']}}</p>
        <p class="text-xs text-slate-500 mt-1">Menunggu</p>
    </div>
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-sky-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-truck text-sky-500"></i></div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['transit']}}</p>
        <p class="text-xs text-slate-500 mt-1">Dalam Perjalanan</p>
    </div>
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-check-circle text-green-500"></i></div>
        <p class="text-2xl font-bold text-blue-900">{{$stats['delivered']}}</p>
        <p class="text-xs text-slate-500 mt-1">Terkirim</p>
    </div>
</div>
<div class="card p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-slate-800">Order Terbaru</h3>
        <a href="{{route('customer.orders.index')}}" class="text-sm text-blue-500 hover:text-blue-700">Lihat Semua →</a>
    </div>
    <div class="space-y-3">
        @forelse($recent_orders as $o)
        <a href="{{route('customer.orders.show',$o)}}" class="flex items-center justify-between p-4 bg-blue-50/60 hover:bg-blue-100/60 rounded-xl transition">
            <div>
                <p class="text-sm font-semibold text-blue-700">{{$o->resi_number}}</p>
                <p class="text-xs text-slate-500">{{$o->receiver_name}} • {{$o->receiver_city}}</p>
                <p class="text-xs text-blue-400 capitalize">{{$o->service_type}}</p>
            </div>
            <div class="text-right">
                <span class="badge-{{$o->current_status}} px-2.5 py-0.5 rounded-full text-xs font-semibold block mb-1">{{$o->status_label}}</span>
                <p class="text-xs font-semibold text-slate-600">Rp {{number_format($o->total_cost,0,',','.')}}</p>
            </div>
        </a>
        @empty
        <div class="py-8 text-center text-slate-400">
            <i class="fas fa-box text-3xl text-blue-200 mb-2 block"></i>
            <p class="text-sm">Belum ada order. <a href="{{route('customer.orders.create')}}" class="text-blue-500 hover:underline">Kirim sekarang!</a></p>
        </div>
        @endforelse
    </div>
</div>
@endsection
