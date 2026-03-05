<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model {
    protected $fillable = ['user_id','courier_code','vehicle_type','vehicle_plate','is_available'];
    public function user()   { return $this->belongsTo(User::class); }
    public function orders() { return $this->hasMany(Order::class); }
}
