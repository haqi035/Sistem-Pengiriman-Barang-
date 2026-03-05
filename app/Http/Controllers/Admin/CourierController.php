<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Courier, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CourierController extends Controller {
    public function index(Request $request) {
        $query = Courier::with('user');
        if ($request->search) $query->whereHas('user', fn($q) => $q->where('name','like','%'.$request->search.'%'));
        $couriers = $query->latest()->paginate(15)->appends($request->all());
        return view('admin.couriers.index', compact('couriers'));
    }

    public function create() { return view('admin.couriers.create'); }

    public function store(Request $request) {
        $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6',
            'phone'         => 'nullable|string|max:20',
            'vehicle_type'  => 'required|in:motor,mobil,truck',
            'vehicle_plate' => 'nullable|string|max:20',
        ]);

        DB::transaction(function() use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'phone'    => $request->phone,
                'role'     => 'courier',
                'is_active'=> 1,
            ]);
            $last = Courier::count() + 1;
            Courier::create([
                'user_id'       => $user->id,
                'courier_code'  => 'KUR-' . str_pad($last, 3, '0', STR_PAD_LEFT),
                'vehicle_type'  => $request->vehicle_type,
                'vehicle_plate' => $request->vehicle_plate,
                'is_available'  => 1,
            ]);
        });

        return redirect()->route('admin.couriers.index')->with('success', 'Kurir berhasil ditambahkan.');
    }

    public function edit(Courier $courier) {
        $courier->load('user');
        return view('admin.couriers.edit', compact('courier'));
    }

    public function update(Request $request, Courier $courier) {
        $request->validate([
            'name'          => 'required|string|max:100',
            'phone'         => 'nullable|string|max:20',
            'vehicle_type'  => 'required|in:motor,mobil,truck',
            'vehicle_plate' => 'nullable|string|max:20',
        ]);
        $courier->user->update(['name'=>$request->name,'phone'=>$request->phone]);
        $courier->update([
            'vehicle_type'  => $request->vehicle_type,
            'vehicle_plate' => $request->vehicle_plate,
            'is_available'  => $request->boolean('is_available'),
        ]);
        return redirect()->route('admin.couriers.index')->with('success', 'Data kurir diperbarui.');
    }

public function destroy(Courier $courier) {
    $userId = $courier->user_id;
    $courier->delete();
    \App\Models\User::find($userId)->delete();
    return redirect()->route('admin.couriers.index')->with('success', 'Kurir dihapus.');
}}
