<?php
namespace App\Http\Controllers\Courier;
use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller {
    public function index() {
        $courier = auth()->user()->courier;

        if (!$courier) {
            abort(404, 'Data kurir tidak ditemukan di tabel couriers.');
        }

        $stats = [
            'today_deliveries' => Order::where('courier_id',$courier->id)->whereDate('created_at',today())->count(),
            'pending'          => Order::where('courier_id',$courier->id)->where('current_status','pickup')->count(),
            'in_transit'       => Order::where('courier_id',$courier->id)->where('current_status','in_transit')->count(),
            'delivered'        => Order::where('courier_id',$courier->id)->where('current_status','delivered')->count(),
        ];

        $recent_orders = Order::with(['originZone','destinationZone'])
            ->where('courier_id',$courier->id)->latest()->take(8)->get();

        return view('courier.dashboard', compact('stats','recent_orders','courier'));
    }
}