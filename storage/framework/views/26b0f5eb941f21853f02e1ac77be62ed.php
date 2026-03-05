<?php $__env->startSection('title','Riwayat Order'); ?>
<?php $__env->startSection('page-title','Riwayat Order'); ?>
<?php $__env->startSection('content'); ?>
<div class="card p-6">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <form method="GET" class="flex gap-3">
            <select name="status" class="border border-blue-100 rounded-xl px-4 py-2.5 text-sm bg-blue-50/30 focus:outline-none focus:ring-2 focus:ring-blue-200">
                <option value="">Semua Status</option>
                <option value="pending" <?php echo e(request('status')=='pending'?'selected':''); ?>>Pending</option>
                <option value="pickup" <?php echo e(request('status')=='pickup'?'selected':''); ?>>Pickup</option>
                <option value="in_transit" <?php echo e(request('status')=='in_transit'?'selected':''); ?>>Dalam Perjalanan</option>
                <option value="delivered" <?php echo e(request('status')=='delivered'?'selected':''); ?>>Terkirim</option>
                <option value="cancelled" <?php echo e(request('status')=='cancelled'?'selected':''); ?>>Dibatalkan</option>
            </select>
            <button type="submit" class="btn-primary">Filter</button>
        </form>
        <a href="<?php echo e(route('customer.orders.create')); ?>" class="btn-primary flex items-center gap-2"><i class="fas fa-plus"></i><span>Order Baru</span></a>
    </div>
    <div class="space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="border border-blue-100 hover:border-blue-300 rounded-xl p-5 transition">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-3">
                        <a href="<?php echo e(route('customer.orders.show',$o)); ?>" class="text-base font-bold text-blue-600 hover:text-blue-800"><?php echo e($o->resi_number); ?></a>
                        <span class="badge-<?php echo e($o->current_status); ?> px-2.5 py-0.5 rounded-full text-xs font-semibold"><?php echo e($o->status_label); ?></span>
                        <span class="text-xs text-slate-400 capitalize bg-slate-50 px-2 py-0.5 rounded-lg"><?php echo e($o->service_type); ?></span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i class="fas fa-map-marker-alt text-blue-300"></i>
                        <span><?php echo e($o->sender_city); ?></span>
                        <i class="fas fa-arrow-right text-blue-200 text-xs"></i>
                        <span class="font-medium"><?php echo e($o->receiver_city); ?></span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1"><?php echo e($o->receiver_name); ?> • <?php echo e($o->created_at->format('d M Y')); ?></p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-base font-bold text-blue-700">Rp <?php echo e(number_format($o->total_cost,0,',','.')); ?></p>
                    <p class="text-xs text-slate-400"><?php echo e($o->weight); ?> kg</p>
                    <a href="<?php echo e(route('customer.orders.show',$o)); ?>" class="mt-2 btn-secondary py-1.5 px-3 text-xs inline-block">Detail</a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="py-16 text-center text-slate-400">
            <i class="fas fa-boxes text-4xl text-blue-200 mb-3 block"></i>
            <p class="font-medium text-slate-500">Belum ada order</p>
            <a href="<?php echo e(route('customer.orders.create')); ?>" class="mt-3 btn-primary inline-flex items-center gap-2">
                <i class="fas fa-plus"></i><span>Kirim Paket Pertama</span>
            </a>
        </div>
        <?php endif; ?>
    </div>
    <div class="mt-4"><?php echo e($orders->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/customer/orders/index.blade.php ENDPATH**/ ?>