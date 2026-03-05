<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\{Order, OrderStatus, Zone, Rate};
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index(Request $request) {
        $query = Order::with(['originZone','destinationZone','courier.user'])->where('user_id',auth()->id());
        if ($request->status) $query->where('current_status',$request->status);
        $orders = $query->latest()->paginate(10)->appends($request->all());
        return view('customer.orders.index', compact('orders'));
    }

    public function create() {
        $zones = Zone::where('is_active',1)->get();
        return view('customer.orders.create', compact('zones'));
    }

    public function getRate(Request $request) {
        $rate = Rate::where('origin_zone_id',$request->origin)
            ->where('destination_zone_id',$request->destination)
            ->where('service_type',$request->service)
            ->where('is_active',1)->first();
        if (!$rate) return response()->json(['error'=>'Tarif tidak tersedia'],404);
        $weight = max((float)$request->weight, $rate->min_weight);
        $cost   = $weight * $rate->price_per_kg;
        return response()->json([
            'price_per_kg'   => $rate->price_per_kg,
            'shipping_cost'  => $cost,
            'estimated_days' => $rate->estimated_days,
            'formatted_cost' => 'Rp '.number_format($cost,0,',','.'),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'origin_zone_id'      => 'required|exists:zones,id',
            'destination_zone_id' => 'required|exists:zones,id|different:origin_zone_id',
            'service_type'        => 'required|in:regular,express,same_day',
            'sender_name'         => 'required|string|max:100',
            'sender_phone'        => 'required|string|max:20',
            'sender_address'      => 'required|string',
            'sender_city'         => 'required|string|max:100',
            'receiver_name'       => 'required|string|max:100',
            'receiver_phone'      => 'required|string|max:20',
            'receiver_address'    => 'required|string',
            'receiver_city'       => 'required|string|max:100',
            'package_name'        => 'required|string|max:200',
            'package_type'        => 'required|in:regular,fragile,document,elektronik',
            'weight'              => 'required|numeric|min:0.1',
        ]);

        $rate = Rate::where('origin_zone_id',$request->origin_zone_id)
            ->where('destination_zone_id',$request->destination_zone_id)
            ->where('service_type',$request->service_type)
            ->where('is_active',1)->firstOrFail();

        $weight        = max((float)$request->weight, $rate->min_weight);
        $shipping_cost = $weight * $rate->price_per_kg;

        $order = Order::create(array_merge($request->only([
            'origin_zone_id','destination_zone_id','service_type',
            'sender_name','sender_phone','sender_address','sender_city',
            'receiver_name','receiver_phone','receiver_address','receiver_city',
            'package_name','package_type','weight','length','width','height','notes'
        ]), [
            'resi_number'       => Order::generateResi(),
            'user_id'           => auth()->id(),
            'shipping_cost'     => $shipping_cost,
            'total_cost'        => $shipping_cost,
            'current_status'    => 'pending',
            'estimated_delivery'=> now()->addDays($rate->estimated_days)->toDateString(),
        ]));

        OrderStatus::create([
            'order_id'    => $order->id,
            'status'      => 'pending',
            'description' => 'Pesanan berhasil dibuat, menunggu konfirmasi.',
            'location'    => $request->sender_city,
            'updated_by'  => auth()->id(),
        ]);

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Order berhasil! Resi: '.$order->resi_number);
    }

    public function show(Order $order) {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load(['originZone','destinationZone','courier.user','statuses.updatedBy']);
        return view('customer.orders.show', compact('order'));
    }
}