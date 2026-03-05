<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        'resi_number','user_id','courier_id','origin_zone_id','destination_zone_id',
        'service_type','sender_name','sender_phone','sender_address','sender_city',
        'receiver_name','receiver_phone','receiver_address','receiver_city',
        'package_name','package_type','weight','length','width','height',
        'shipping_cost','insurance_cost','total_cost','current_status',
        'notes','estimated_delivery','delivered_at'
    ];
    protected $casts = ['estimated_delivery'=>'date','delivered_at'=>'datetime'];

    public function user()            { return $this->belongsTo(User::class); }
    public function courier()         { return $this->belongsTo(Courier::class); }
    public function originZone()      { return $this->belongsTo(Zone::class, 'origin_zone_id'); }
    public function destinationZone() { return $this->belongsTo(Zone::class, 'destination_zone_id'); }
    public function statuses()        { return $this->hasMany(OrderStatus::class)->orderBy('created_at','desc'); }
    public function latestStatus()    { return $this->hasOne(OrderStatus::class)->latestOfMany(); }

    public static function generateResi(): string {
        $date = now()->format('Ymd');
        $last = self::whereDate('created_at', today())->count() + 1;
        return 'SHP-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute(): string {
        return match($this->current_status) {
            'pending'    => 'badge-pending',
            'pickup'     => 'badge-pickup',
            'in_transit' => 'badge-transit',
            'delivered'  => 'badge-delivered',
            'cancelled'  => 'badge-cancelled',
            default      => 'badge-pending'
        };
    }

    public function getStatusLabelAttribute(): string {
        return match($this->current_status) {
            'pending'    => 'Menunggu',
            'pickup'     => 'Pickup',
            'in_transit' => 'Dalam Perjalanan',
            'delivered'  => 'Terkirim',
            'cancelled'  => 'Dibatalkan',
            default      => 'Menunggu'
        };
    }
}
