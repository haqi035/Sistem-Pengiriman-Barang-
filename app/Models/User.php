<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ['name','email','password','role','phone','is_active'];
    protected $hidden   = ['password','remember_token'];
    protected $casts    = ['email_verified_at'=>'datetime','password'=>'hashed'];

    public function courier()  { return $this->hasOne(Courier::class); }
    public function orders()   { return $this->hasMany(Order::class); }
    public function isAdmin()  { return $this->role === 'admin'; }
    public function isCourier(){ return $this->role === 'courier'; }
    public function isCustomer(){ return $this->role === 'customer'; }
}
