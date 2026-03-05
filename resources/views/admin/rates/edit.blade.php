@extends('layouts.app')
@section('title','Edit Tarif')
@section('page-title','Edit Tarif')
@section('content')
<div class="max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{route('admin.rates.index')}}" class="btn-secondary py-2 px-4 text-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
    </div>
    <div class="card p-6">
        <div class="mb-5 p-4 bg-blue-50 rounded-xl">
            <p class="text-sm font-semibold text-blue-800">{{$rate->originZone->city}} → {{$rate->destinationZone->city}}</p>
            <p class="text-xs text-blue-500 capitalize">{{$rate->service_type}}</p>
        </div>
        <form method="POST" action="{{route('admin.rates.update',$rate)}}" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-2">Harga/kg (Rp)</label>
                <input type="number" name="price_per_kg" value="{{old('price_per_kg',$rate->price_per_kg)}}" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-2">Min. Berat</label>
                <input type="number" name="min_weight" value="{{old('min_weight',$rate->min_weight)}}" required step="0.1" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-2">Est. Hari</label>
                <input type="number" name="estimated_days" value="{{old('estimated_days',$rate->estimated_days)}}" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            </div>
            <div class="flex items-center gap-3">
                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{$rate->is_active?'checked':''}} class="rounded border-blue-200 text-blue-500">
                    <span>Aktif</span>
                </label>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{route('admin.rates.index')}}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
