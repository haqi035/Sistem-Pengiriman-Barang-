<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Rate, Zone};
use Illuminate\Http\Request;

class RateController extends Controller {
    public function index() {
        $rates = Rate::with(['originZone','destinationZone'])->latest()->paginate(20);
        return view('admin.rates.index', compact('rates'));
    }

    public function create() {
        $zones = Zone::where('is_active',1)->get();
        return view('admin.rates.create', compact('zones'));
    }

    public function store(Request $request) {
        $request->validate([
            'origin_zone_id'      => 'required|exists:zones,id',
            'destination_zone_id' => 'required|exists:zones,id|different:origin_zone_id',
            'service_type'        => 'required|in:regular,express,same_day',
            'price_per_kg'        => 'required|numeric|min:0',
            'min_weight'          => 'required|numeric|min:0.1',
            'estimated_days'      => 'required|integer|min:1',
        ]);
        Rate::create($request->all());
        return redirect()->route('admin.rates.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit(Rate $rate) {
        $zones = Zone::where('is_active',1)->get();
        return view('admin.rates.edit', compact('rate','zones'));
    }

    public function update(Request $request, Rate $rate) {
        $request->validate([
            'price_per_kg'   => 'required|numeric|min:0',
            'min_weight'     => 'required|numeric|min:0.1',
            'estimated_days' => 'required|integer|min:1',
        ]);
        $rate->update($request->all());
        return redirect()->route('admin.rates.index')->with('success', 'Tarif diperbarui.');
    }

    public function destroy(Rate $rate) {
        $rate->delete();
        return redirect()->route('admin.rates.index')->with('success', 'Tarif dihapus.');
    }
}
