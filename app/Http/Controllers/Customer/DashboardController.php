<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller {
    public function index() {
        $userId = auth()->id();
        $stats = [
            'total'     => Order::where('user_id',$userId)->count(),
            'pending'   => Order::where('user_id',$userId)->where('current_status','pending')->count(),
            'transit'   => Order::where('user_id',$userId)->whereIn('current_status',['pickup','in_transit'])->count(),
            'delivered' => Order::where('user_id',$userId)->where('current_status','delivered')->count(),
        ];
        $recent_orders = Order::with(['originZone','destinationZone'])
            ->where('user_id',$userId)->latest()->take(5)->get();
        return view('customer.dashboard', compact('stats','recent_orders'));
    }
}