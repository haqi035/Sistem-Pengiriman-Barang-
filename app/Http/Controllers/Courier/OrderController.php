<?php
namespace App\Http\Controllers\Courier;
use App\Http\Controllers\Controller;
use App\Models\{Order, OrderStatus};
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index(Request $request) {
        $courier = auth()->user()->courier;
        $query = Order::with(['originZone','destinationZone','user'])->where('courier_id',$courier->id);
        if ($request->status) $query->where('current_status',$request->status);
        $orders = $query->latest()->paginate(15)->appends($request->all());
        return view('courier.orders.index', compact('orders'));
    }

    public function show(Order $order) {
        $courier = auth()->user()->courier;
        if ($order->courier_id !== $courier->id) abort(403);
        $order->load(['user','originZone','destinationZone','statuses.updatedBy']);
        return view('courier.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order) {
        $courier = auth()->user()->courier;
        if ($order->courier_id !== $courier->id) abort(403);

        $request->validate([
            'status'      => 'required|in:pickup,in_transit,delivered,cancelled',
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

        return back()->with('success', 'Status pengiriman diperbarui.');
    }
}
