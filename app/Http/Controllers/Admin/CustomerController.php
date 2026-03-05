<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller {
    public function index(Request $request) {
        $query = User::where('role','customer');
        if ($request->search) $query->where(function($q) use($request){
            $q->where('name','like','%'.$request->search.'%')
              ->orWhere('email','like','%'.$request->search.'%');
        });
        $customers = $query->withCount('orders')->latest()->paginate(15)->appends($request->all());
        return view('admin.customers.index', compact('customers'));
    }

    public function create() { return view('admin.customers.create'); }

    public function store(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
        ]);
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'phone'     => $request->phone,
            'role'      => 'customer',
            'is_active' => 1,
        ]);
        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(User $customer) { return view('admin.customers.edit', compact('customer')); }

    public function update(Request $request, User $customer) {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$customer->id,
            'phone' => 'nullable|string|max:20',
        ]);
        $data = $request->only('name','email','phone','is_active');
        if ($request->password) $data['password'] = Hash::make($request->password);
        $customer->update($data);
        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan diperbarui.');
    }

    public function destroy(User $customer) {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan dihapus.');
    }
}
