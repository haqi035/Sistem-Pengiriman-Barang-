<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model {
    protected $fillable = ['origin_zone_id','destination_zone_id','service_type','price_per_kg','min_weight','estimated_days','is_active'];
    public function originZone()      { return $this->belongsTo(Zone::class, 'origin_zone_id'); }
    public function destinationZone() { return $this->belongsTo(Zone::class, 'destination_zone_id'); }
}
