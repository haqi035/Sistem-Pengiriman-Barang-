<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\Admin\DashboardController as AdminDash;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CourierController as AdminCourier;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Courier\DashboardController as CourierDash;
use App\Http\Controllers\Courier\OrderController as CourierOrder;
use App\Http\Controllers\Customer\DashboardController as CustomerDash;
use App\Http\Controllers\Customer\OrderController as CustomerOrder;

Route::get('/', function() {
    if (auth()->check()) {
        return match(auth()->user()->role) {
            'admin'   => redirect('/admin/dashboard'),
            'courier' => redirect('/courier/dashboard'),
            default   => redirect('/customer/dashboard'),
        };
    }
    return redirect('/login');
});

Route::get('/login',  [LoginController::class,'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class,'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth');
Route::get('/lacak', [TrackingController::class,'index'])->name('tracking');

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDash::class,'index'])->name('dashboard');
    Route::resource('orders', AdminOrder::class)->only(['index','show','destroy']);
    Route::post('/orders/{order}/assign-courier', [AdminOrder::class,'assignCourier'])->name('orders.assignCourier');
    Route::post('/orders/{order}/update-status',  [AdminOrder::class,'updateStatus'])->name('orders.updateStatus');
    Route::resource('customers', CustomerController::class)->except(['show']);
    Route::resource('couriers',  AdminCourier::class)->except(['show']);
    Route::resource('zones',     ZoneController::class)->except(['show']);
    Route::resource('rates',     RateController::class)->except(['show']);
    Route::get('/reports', [ReportController::class,'index'])->name('reports.index');
});

Route::middleware(['auth','role:courier'])->prefix('courier')->name('courier.')->group(function () {
    Route::get('/dashboard', [CourierDash::class,'index'])->name('dashboard');
    Route::resource('orders', CourierOrder::class)->only(['index','show']);
    Route::post('/orders/{order}/update-status', [CourierOrder::class,'updateStatus'])->name('orders.updateStatus');
});

Route::middleware(['auth','role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard',     [CustomerDash::class,'index'])->name('dashboard');
    Route::get('/orders',        [CustomerOrder::class,'index'])->name('orders.index');
    Route::get('/orders/create', [CustomerOrder::class,'create'])->name('orders.create');
    Route::post('/orders',       [CustomerOrder::class,'store'])->name('orders.store');
    Route::get('/orders/{order}',[CustomerOrder::class,'show'])->name('orders.show');
    Route::get('/get-rate',      [CustomerOrder::class,'getRate'])->name('orders.getRate');
});