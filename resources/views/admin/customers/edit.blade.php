@extends('layouts.app')
@section('title','Edit Pelanggan')
@section('page-title','Edit Pelanggan')
@section('content')
<div class="max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{route('admin.customers.index')}}" class="btn-secondary py-2 px-4 text-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
    </div>
    <div class="card p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-6">Edit Data Pelanggan</h2>
        <form method="POST" action="{{route('admin.customers.update',$customer)}}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{old('name',$customer->name)}}" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Email <span class="text-red-400">*</span></label>
                <input type="email" name="email" value="{{old('email',$customer->email)}}" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">No. HP</label>
                <input type="text" name="phone" value="{{old('phone',$customer->phone)}}" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru (isi jika ingin ubah)</label>
                <input type="password" name="password" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
            </div>
            <div class="flex items-center gap-3">
                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{$customer->is_active?'checked':''}} class="rounded border-blue-200 text-blue-500">
                    <span>Akun Aktif</span>
                </label>
            </div>
            <div class="pt-2 flex gap-3">
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                <a href="{{route('admin.customers.index')}}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
