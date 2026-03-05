<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Order, User, Courier, Zone};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'total_orders'     => Order::count(),
            'pending_orders'   => Order::where('current_status','pending')->count(),
            'transit_orders'   => Order::where('current_status','in_transit')->count(),
            'delivered_orders' => Order::where('current_status','delivered')->count(),
            'total_customers'  => User::where('role','customer')->count(),
            'total_couriers'   => User::where('role','courier')->count(),
            'today_orders'     => Order::whereDate('created_at', today())->count(),
            'today_revenue'    => Order::whereDate('created_at', today())->sum('total_cost'),
            'month_revenue'    => Order::whereMonth('created_at', now()->month)->sum('total_cost'),
        ];

        $recent_orders = Order::with(['user','originZone','destinationZone','courier.user'])
            ->latest()->take(10)->get();

        $chart_data = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(total_cost) as revenue')
            )->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy('date')->orderBy('date')->get();

        return view('admin.dashboard', compact('stats','recent_orders','chart_data'));
    }
}
