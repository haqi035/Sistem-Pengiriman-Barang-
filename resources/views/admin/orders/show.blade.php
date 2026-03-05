@extends('layouts.app')
@section('title','Detail Order')
@section('page-title','Detail Order - '.$order->resi_number)
@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{route('admin.orders.index')}}" class="btn-secondary text-sm py-2 px-4"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        {{-- Info Order --}}
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-bold text-blue-900">{{$order->resi_number}}</h2>
                    <p class="text-sm text-slate-500 capitalize mt-1">{{$order->service_type}} • {{$order->package_type}}</p>
                </div>
                <span class="badge-{{$order->current_status}} px-3 py-1.5 rounded-full text-sm font-semibold">{{$order->status_label}}</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-blue-600 mb-3 uppercase tracking-wider">Pengirim</p>
                    <p class="font-semibold text-slate-800">{{$order->sender_name}}</p>
                    <p class="text-sm text-slate-600">{{$order->sender_phone}}</p>
                    <p class="text-sm text-slate-500 mt-1">{{$order->sender_address}}</p>
                    <p class="text-sm text-blue-500 font-medium mt-1">{{$order->sender_city}}</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-blue-600 mb-3 uppercase tracking-wider">Penerima</p>
                    <p class="font-semibold text-slate-800">{{$order->receiver_name}}</p>
                    <p class="text-sm text-slate-600">{{$order->receiver_phone}}</p>
                    <p class="text-sm text-slate-500 mt-1">{{$order->receiver_address}}</p>
                    <p class="text-sm text-blue-500 font-medium mt-1">{{$order->receiver_city}}</p>
                </div>
            </div>
            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-slate-500">Berat</p>
                    <p class="font-bold text-slate-800">{{$order->weight}} kg</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-slate-500">Layanan</p>
                    <p class="font-bold text-slate-800 capitalize">{{$order->service_type}}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-slate-500">Biaya Kirim</p>
                    <p class="font-bold text-blue-600">Rp {{number_format($order->total_cost,0,',','.')}}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-slate-500">Est. Tiba</p>
                    <p class="font-bold text-slate-800">{{$order->estimated_delivery?$order->estimated_delivery->format('d M Y'):'-'}}</p>
                </div>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="card p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Update Status</h3>
            <form method="POST" action="{{route('admin.orders.updateStatus',$order)}}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status Baru</label>
                        <select name="status" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                            <option value="pending" {{$order->current_status=='pending'?'selected':''}}>Pending</option>
                            <option value="pickup" {{$order->current_status=='pickup'?'selected':''}}>Pickup</option>
                            <option value="in_transit" {{$order->current_status=='in_transit'?'selected':''}}>Dalam Perjalanan</option>
                            <option value="delivered" {{$order->current_status=='delivered'?'selected':''}}>Terkirim</option>
                            <option value="cancelled" {{$order->current_status=='cancelled'?'selected':''}}>Dibatalkan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Lokasi Saat Ini</label>
                        <input type="text" name="location" placeholder="Contoh: Jakarta Pusat" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                    <input type="text" name="description" required placeholder="Keterangan update status..." class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                </div>
                <button type="submit" class="btn-primary">Update Status</button>
            </form>
        </div>

        {{-- Assign Kurir --}}
        @if(!$order->courier_id || $order->current_status==='pending')
        <div class="card p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Tugaskan Kurir</h3>
            <form method="POST" action="{{route('admin.orders.assignCourier',$order)}}" class="flex gap-3">
                @csrf
                <select name="courier_id" required class="flex-1 border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                    <option value="">Pilih Kurir</option>
                    @foreach($couriers as $c)
                    <option value="{{$c->id}}" {{$order->courier_id==$c->id?'selected':''}}>{{$c->user->name}} ({{$c->courier_code}}) - {{ucfirst($c->vehicle_type)}}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary">Tugaskan</button>
            </form>
        </div>
        @endif
    </div>

    {{-- Timeline & Info --}}
    <div class="space-y-6">
        <div class="card p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Info Kurir</h3>
            @if($order->courier)
            <div class="bg-blue-50 rounded-xl p-4">
                <p class="font-semibold text-slate-800">{{$order->courier->user->name}}</p>
                <p class="text-sm text-slate-600">{{$order->courier->courier_code}}</p>
                <p class="text-sm text-slate-500 capitalize mt-1">{{$order->courier->vehicle_type}} - {{$order->courier->vehicle_plate}}</p>
                <p class="text-sm text-slate-500">{{$order->courier->user->phone}}</p>
            </div>
            @else
            <p class="text-sm text-orange-500 bg-orange-50 rounded-xl p-3"><i class="fas fa-exclamation-triangle mr-2"></i>Belum ada kurir ditugaskan</p>
            @endif
        </div>

        <div class="card p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Riwayat Status</h3>
            <div class="space-y-4">
                @foreach($order->statuses as $s)
                <div class="flex gap-3">
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center {{$loop->first?'bg-blue-500':'bg-blue-100'}}">
                            <i class="fas {{$loop->first?'fa-check text-white':'fa-circle text-blue-300'}} text-xs"></i>
                        </div>
                        @if(!$loop->last)<div class="w-0.5 h-6 bg-blue-100 mt-1"></div>@endif
                    </div>
                    <div class="pb-3">
                        <p class="text-sm font-semibold text-slate-800">{{ucfirst(str_replace('_',' ',$s->status))}}</p>
                        <p class="text-xs text-slate-500">{{$s->description}}</p>
                        @if($s->location)<p class="text-xs text-blue-400"><i class="fas fa-map-marker-alt mr-1"></i>{{$s->location}}</p>@endif
                        <p class="text-xs text-slate-400">{{$s->created_at->format('d M Y, H:i')}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
