<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model {
    protected $fillable = ['name','province','city','postal_code','is_active'];
    public function originRates()      { return $this->hasMany(Rate::class, 'origin_zone_id'); }
    public function destinationRates() { return $this->hasMany(Rate::class, 'destination_zone_id'); }
    public function getFullNameAttribute() { return $this->city . ' - ' . $this->province; }
}
