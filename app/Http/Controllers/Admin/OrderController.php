<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Order, OrderStatus, Courier, Zone, Rate};
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index(Request $request) {
        $query = Order::with(['user','originZone','destinationZone','courier.user']);
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('resi_number','like','%'.$request->search.'%')
                  ->orWhere('sender_name','like','%'.$request->search.'%')
                  ->orWhere('receiver_name','like','%'.$request->search.'%');
            });
        }
        if ($request->status) $query->where('current_status', $request->status);
        if ($request->service) $query->where('service_type', $request->service);
        $orders = $query->latest()->paginate(15)->appends($request->all());
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order) {
        $order->load(['user','originZone','destinationZone','courier.user','statuses.updatedBy']);
        $couriers = Courier::with('user')->where('is_available',1)->get();
        return view('admin.orders.show', compact('order','couriers'));
    }

    public function assignCourier(Request $request, Order $order) {
        $request->validate(['courier_id' => 'required|exists:couriers,id']);
        $order->update(['courier_id' => $request->courier_id]);
        return back()->with('success', 'Kurir berhasil ditugaskan.');
    }

    public function updateStatus(Request $request, Order $order) {
        $request->validate([
            'status'      => 'required|in:pending,pickup,in_transit,delivered,cancelled',
            'description' => 'required|string|max:500',
            'location'    => 'nullable|string|max:200',
        ]);

        $order->update(['current_status' => $request->status]);
        if ($request->status === 'delivered') $order->update(['delivered_at' => now()]);

        OrderStatus::create([
            'order_id'    => $order->id,
            'status'      => $request->status,
            'description' => $request->description,
            'location'    => $request->location,
            'updated_by'  => auth()->id(),
        ]);

        return back()->with('success', 'Status order berhasil diperbarui.');
    }

    public function destroy(Order $order) {
        $order->statuses()->delete();
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus.');
    }
}
