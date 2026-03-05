@extends('layouts.app')
@section('title','Tambah Kurir')
@section('page-title','Tambah Kurir')
@section('content')
<div class="max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{route('admin.couriers.index')}}" class="btn-secondary py-2 px-4 text-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
    </div>
    <div class="card p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-6">Data Kurir Baru</h2>
        <form method="POST" action="{{route('admin.couriers.store')}}" class="space-y-4">
            @csrf
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Nama <span class="text-red-400">*</span></label>
            <input type="text" name="name" value="{{old('name')}}" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Email <span class="text-red-400">*</span></label>
            <input type="email" name="email" value="{{old('email')}}" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">No. HP</label>
            <input type="text" name="phone" value="{{old('phone')}}" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Password <span class="text-red-400">*</span></label>
            <input type="password" name="password" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kendaraan <span class="text-red-400">*</span></label>
            <select name="vehicle_type" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                <option value="motor" {{old('vehicle_type')=='motor'?'selected':''}}>Motor</option>
                <option value="mobil" {{old('vehicle_type')=='mobil'?'selected':''}}>Mobil</option>
                <option value="truck" {{old('vehicle_type')=='truck'?'selected':''}}>Truck</option>
            </select></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">No. Plat Kendaraan</label>
            <input type="text" name="vehicle_plate" value="{{old('vehicle_plate')}}" placeholder="B 1234 ABC" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div class="pt-2 flex gap-3">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{route('admin.couriers.index')}}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
