<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {
    public function index(Request $request) {
        $start = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $end   = $request->end_date   ?? now()->format('Y-m-d');

        $summary = [
            'total_orders'     => Order::whereBetween('created_at',[$start.' 00:00:00',$end.' 23:59:59'])->count(),
            'delivered_orders' => Order::whereBetween('created_at',[$start.' 00:00:00',$end.' 23:59:59'])->where('current_status','delivered')->count(),
            'pending_orders'   => Order::whereBetween('created_at',[$start.' 00:00:00',$end.' 23:59:59'])->where('current_status','pending')->count(),
            'total_revenue'    => Order::whereBetween('created_at',[$start.' 00:00:00',$end.' 23:59:59'])->sum('total_cost'),
        ];

        $daily = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(total_cost) as revenue')
            )->whereBetween('created_at',[$start.' 00:00:00',$end.' 23:59:59'])
            ->groupBy('date')->orderBy('date')->get();

        $by_status = Order::select('current_status', DB::raw('count(*) as total'))
            ->whereBetween('created_at',[$start.' 00:00:00',$end.' 23:59:59'])
            ->groupBy('current_status')->get();

        $orders = Order::with(['user','originZone','destinationZone','courier.user'])
            ->whereBetween('created_at',[$start.' 00:00:00',$end.' 23:59:59'])
            ->latest()->paginate(20)->appends($request->all());

        return view('admin.reports.index', compact('summary','daily','by_status','orders','start','end'));
    }
}
