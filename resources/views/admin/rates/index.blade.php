@extends('layouts.app')
@section('title','Tarif')
@section('page-title','Kelola Tarif')
@section('content')
<div class="card p-6">
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-slate-500">Daftar tarif pengiriman per zona</p>
        <a href="{{route('admin.rates.create')}}" class="btn-primary flex items-center gap-2"><i class="fas fa-plus"></i><span>Tambah Tarif</span></a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-50">
                <th class="pb-3 pr-4">Asal → Tujuan</th><th class="pb-3 pr-4">Layanan</th>
                <th class="pb-3 pr-4">Harga/kg</th><th class="pb-3 pr-4">Min. Berat</th>
                <th class="pb-3 pr-4">Est. Hari</th><th class="pb-3 pr-4">Status</th><th class="pb-3">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-blue-50">
                @forelse($rates as $r)
                <tr class="hover:bg-blue-50/30 transition">
                    <td class="py-3.5 pr-4">
                        <p class="text-sm font-medium text-slate-700">{{$r->originZone->city}}</p>
                        <p class="text-xs text-slate-400">→ {{$r->destinationZone->city}}</p>
                    </td>
                    <td class="py-3.5 pr-4">
                        <span class="{{$r->service_type=='express'?'bg-orange-100 text-orange-600':($r->service_type=='same_day'?'bg-red-100 text-red-600':'bg-blue-100 text-blue-600')}} px-2.5 py-1 rounded-full text-xs font-semibold capitalize">
                            {{$r->service_type}}
                        </span>
                    </td>
                    <td class="py-3.5 pr-4 text-sm font-semibold text-slate-700">Rp {{number_format($r->price_per_kg,0,',','.')}}</td>
                    <td class="py-3.5 pr-4 text-sm text-slate-600">{{$r->min_weight}} kg</td>
                    <td class="py-3.5 pr-4 text-sm text-slate-600">{{$r->estimated_days}} hari</td>
                    <td class="py-3.5 pr-4">
                        <span class="{{$r->is_active?'bg-green-100 text-green-600':'bg-red-100 text-red-500'}} px-2.5 py-1 rounded-full text-xs font-semibold">
                            {{$r->is_active?'Aktif':'Nonaktif'}}
                        </span>
                    </td>
                    <td class="py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="{{route('admin.rates.edit',$r)}}" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{route('admin.rates.destroy',$r)}}" onsubmit="return confirm('Hapus tarif ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="py-12 text-center text-slate-400 text-sm">Belum ada tarif</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{$rates->links()}}</div>
</div>
@endsection
