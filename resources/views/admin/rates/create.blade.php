@extends('layouts.app')
@section('title','Tambah Tarif')
@section('page-title','Tambah Tarif')
@section('content')
<div class="max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{route('admin.rates.index')}}" class="btn-secondary py-2 px-4 text-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
    </div>
    <div class="card p-6">
        <form method="POST" action="{{route('admin.rates.store')}}" class="space-y-4">
            @csrf
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Zona Asal <span class="text-red-400">*</span></label>
            <select name="origin_zone_id" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                <option value="">Pilih Zona Asal</option>
                @foreach($zones as $z)<option value="{{$z->id}}" {{old('origin_zone_id')==$z->id?'selected':''}}>{{$z->city}} - {{$z->province}}</option>@endforeach
            </select>
            @error('origin_zone_id')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror</div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Zona Tujuan <span class="text-red-400">*</span></label>
            <select name="destination_zone_id" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                <option value="">Pilih Zona Tujuan</option>
                @foreach($zones as $z)<option value="{{$z->id}}" {{old('destination_zone_id')==$z->id?'selected':''}}>{{$z->city}} - {{$z->province}}</option>@endforeach
            </select>
            @error('destination_zone_id')<p class="text-red-500 text-xs mt-1">{{$message}}</p>@enderror</div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Jenis Layanan <span class="text-red-400">*</span></label>
            <select name="service_type" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                <option value="regular" {{old('service_type')=='regular'?'selected':''}}>Regular</option>
                <option value="express" {{old('service_type')=='express'?'selected':''}}>Express</option>
                <option value="same_day" {{old('service_type')=='same_day'?'selected':''}}>Same Day</option>
            </select></div>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-2">Harga/kg (Rp)</label>
                <input type="number" name="price_per_kg" value="{{old('price_per_kg')}}" required min="0" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-2">Min. Berat (kg)</label>
                <input type="number" name="min_weight" value="{{old('min_weight',1)}}" required min="0.1" step="0.1" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-2">Est. Hari</label>
                <input type="number" name="estimated_days" value="{{old('estimated_days',3)}}" required min="1" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{route('admin.rates.index')}}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
