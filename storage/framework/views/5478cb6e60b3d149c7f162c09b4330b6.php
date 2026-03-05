<?php $__env->startSection('title','Dashboard Kurir'); ?>
<?php $__env->startSection('page-title','Dashboard Kurir'); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
            <i class="fas fa-motorcycle text-2xl"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold">Halo, <?php echo e(auth()->user()->name); ?>!</h2>
            <p class="text-blue-100 text-sm"><?php echo e($courier->courier_code); ?> • <?php echo e(ucfirst($courier->vehicle_type)); ?> <?php echo e($courier->vehicle_plate); ?></p>
        </div>
    </div>
</div>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-calendar-day text-blue-500"></i></div>
        <p class="text-2xl font-bold text-blue-900"><?php echo e($stats['today_deliveries']); ?></p>
        <p class="text-xs text-slate-500 mt-1">Pengiriman Hari Ini</p>
    </div>
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-box text-yellow-500"></i></div>
        <p class="text-2xl font-bold text-blue-900"><?php echo e($stats['pending']); ?></p>
        <p class="text-xs text-slate-500 mt-1">Siap Pickup</p>
    </div>
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-sky-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-truck text-sky-500"></i></div>
        <p class="text-2xl font-bold text-blue-900"><?php echo e($stats['in_transit']); ?></p>
        <p class="text-xs text-slate-500 mt-1">Dalam Perjalanan</p>
    </div>
    <div class="card p-5 text-center">
        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3"><i class="fas fa-check-circle text-green-500"></i></div>
        <p class="text-2xl font-bold text-blue-900"><?php echo e($stats['delivered']); ?></p>
        <p class="text-xs text-slate-500 mt-1">Selesai</p>
    </div>
</div>
<div class="card p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-slate-800">Pengiriman Terbaru</h3>
        <a href="<?php echo e(route('courier.orders.index')); ?>" class="text-sm text-blue-500 hover:text-blue-700">Lihat Semua →</a>
    </div>
    <div class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $recent_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('courier.orders.show',$o)); ?>" class="flex items-center justify-between p-4 bg-blue-50/60 hover:bg-blue-100/60 rounded-xl transition">
            <div>
                <p class="text-sm font-semibold text-blue-700"><?php echo e($o->resi_number); ?></p>
                <p class="text-xs text-slate-500"><?php echo e($o->receiver_name); ?> • <?php echo e($o->receiver_city); ?></p>
            </div>
            <span class="badge-<?php echo e($o->current_status); ?> px-2.5 py-1 rounded-full text-xs font-semibold"><?php echo e($o->status_label); ?></span>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-center text-sm text-slate-400 py-6">Belum ada pengiriman</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/courier/dashboard.blade.php ENDPATH**/ ?>