@extends('layouts.app')
@section('title','Tambah Zona')
@section('page-title','Tambah Zona Wilayah')
@section('content')
<div class="max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{route('admin.zones.index')}}" class="btn-secondary py-2 px-4 text-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
    </div>
    <div class="card p-6">
        <form method="POST" action="{{route('admin.zones.store')}}" class="space-y-4">
            @csrf
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Nama Zona <span class="text-red-400">*</span></label>
            <input type="text" name="name" value="{{old('name')}}" required placeholder="Contoh: Jakarta Pusat" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Provinsi <span class="text-red-400">*</span></label>
            <input type="text" name="province" value="{{old('province')}}" required placeholder="Contoh: DKI Jakarta" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Kota <span class="text-red-400">*</span></label>
            <input type="text" name="city" value="{{old('city')}}" required placeholder="Contoh: Jakarta Pusat" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Kode Pos</label>
            <input type="text" name="postal_code" value="{{old('postal_code')}}" placeholder="10110" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div class="pt-2 flex gap-3">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{route('admin.zones.index')}}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
