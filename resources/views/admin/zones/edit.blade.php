@extends('layouts.app')
@section('title','Edit Zona')
@section('page-title','Edit Zona Wilayah')
@section('content')
<div class="max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{route('admin.zones.index')}}" class="btn-secondary py-2 px-4 text-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
    </div>
    <div class="card p-6">
        <form method="POST" action="{{route('admin.zones.update',$zone)}}" class="space-y-4">
            @csrf @method('PUT')
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Nama Zona</label>
            <input type="text" name="name" value="{{old('name',$zone->name)}}" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Provinsi</label>
            <input type="text" name="province" value="{{old('province',$zone->province)}}" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Kota</label>
            <input type="text" name="city" value="{{old('city',$zone->city)}}" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Kode Pos</label>
            <input type="text" name="postal_code" value="{{old('postal_code',$zone->postal_code)}}" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div class="flex items-center gap-3">
                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{$zone->is_active?'checked':''}} class="rounded border-blue-200 text-blue-500">
                    <span>Aktif</span>
                </label>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{route('admin.zones.index')}}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
