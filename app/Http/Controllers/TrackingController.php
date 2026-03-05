<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller {
    public function index(Request $request) {
        $order = null;
        if ($request->resi) {
            $order = Order::with(['statuses','originZone','destinationZone'])
                ->where('resi_number', $request->resi)->first();
        }
        return view('tracking', compact('order'));
    }
}
