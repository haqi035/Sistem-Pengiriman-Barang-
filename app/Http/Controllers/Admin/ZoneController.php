<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller {
    public function index(Request $request) {
        $query = Zone::query();
        if ($request->search) $query->where('city','like','%'.$request->search.'%')
            ->orWhere('province','like','%'.$request->search.'%');
        $zones = $query->latest()->paginate(15)->appends($request->all());
        return view('admin.zones.index', compact('zones'));
    }

    public function create() { return view('admin.zones.create'); }

    public function store(Request $request) {
        $request->validate([
            'name'        => 'required|string|max:100',
            'province'    => 'required|string|max:100',
            'city'        => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);
        Zone::create($request->all());
        return redirect()->route('admin.zones.index')->with('success', 'Zona berhasil ditambahkan.');
    }

    public function edit(Zone $zone) { return view('admin.zones.edit', compact('zone')); }

    public function update(Request $request, Zone $zone) {
        $request->validate([
            'name'     => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'city'     => 'required|string|max:100',
        ]);
        $zone->update($request->all());
        return redirect()->route('admin.zones.index')->with('success', 'Zona diperbarui.');
    }

    public function destroy(Zone $zone) {
        $zone->delete();
        return redirect()->route('admin.zones.index')->with('success', 'Zona dihapus.');
    }
}
