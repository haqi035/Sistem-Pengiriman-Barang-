<?php $__env->startSection('title','Pengiriman Saya'); ?>
<?php $__env->startSection('page-title','Pengiriman Saya'); ?>
<?php $__env->startSection('content'); ?>
<div class="card p-6">
    <form method="GET" class="flex gap-3 mb-6">
        <select name="status" class="border border-blue-100 rounded-xl px-4 py-2.5 text-sm bg-blue-50/30 focus:outline-none focus:ring-2 focus:ring-blue-200">
            <option value="">Semua Status</option>
            <option value="pickup" <?php echo e(request('status')=='pickup'?'selected':''); ?>>Pickup</option>
            <option value="in_transit" <?php echo e(request('status')=='in_transit'?'selected':''); ?>>Dalam Perjalanan</option>
            <option value="delivered" <?php echo e(request('status')=='delivered'?'selected':''); ?>>Terkirim</option>
            <option value="cancelled" <?php echo e(request('status')=='cancelled'?'selected':''); ?>>Dibatalkan</option>
        </select>
        <button type="submit" class="btn-primary">Filter</button>
        <?php if(request('status')): ?><a href="<?php echo e(route('courier.orders.index')); ?>" class="btn-secondary">Reset</a><?php endif; ?>
    </form>
    <div class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="border border-blue-100 rounded-xl p-4 hover:border-blue-300 transition">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-2">
                        <a href="<?php echo e(route('courier.orders.show',$o)); ?>" class="text-sm font-bold text-blue-600 hover:text-blue-800"><?php echo e($o->resi_number); ?></a>
                        <span class="badge-<?php echo e($o->current_status); ?> px-2.5 py-0.5 rounded-full text-xs font-semibold"><?php echo e($o->status_label); ?></span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <p class="text-xs text-slate-400">Pengirim</p>
                            <p class="text-sm font-medium text-slate-700 truncate"><?php echo e($o->sender_name); ?></p>
                            <p class="text-xs text-slate-500"><?php echo e($o->sender_city); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Penerima</p>
                            <p class="text-sm font-medium text-slate-700 truncate"><?php echo e($o->receiver_name); ?></p>
                            <p class="text-xs text-slate-500"><?php echo e($o->receiver_city); ?></p>
                        </div>
                    </div>
                </div>
                <a href="<?php echo e(route('courier.orders.show',$o)); ?>" class="btn-secondary py-2 px-3 text-xs flex-shrink-0">Detail</a>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="py-12 text-center text-slate-400">
            <i class="fas fa-box text-4xl text-blue-200 mb-3 block"></i>
            <p class="font-medium">Tidak ada pengiriman</p>
        </div>
        <?php endif; ?>
    </div>
    <div class="mt-4"><?php echo e($orders->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/courier/orders/index.blade.php ENDPATH**/ ?>