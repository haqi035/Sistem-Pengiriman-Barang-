<?php $__env->startSection('title','Detail Order'); ?>
<?php $__env->startSection('page-title','Detail Order'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('customer.orders.index')); ?>" class="btn-secondary py-2 px-4 text-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-bold text-blue-900"><?php echo e($order->resi_number); ?></h2>
                    <p class="text-sm text-slate-500 capitalize mt-1"><?php echo e($order->service_type); ?> • <?php echo e($order->package_type); ?></p>
                </div>
                <span class="badge-<?php echo e($order->current_status); ?> px-3 py-1.5 rounded-full text-sm font-semibold"><?php echo e($order->status_label); ?></span>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-blue-600 mb-2">PENGIRIM</p>
                    <p class="font-semibold text-slate-800"><?php echo e($order->sender_name); ?></p>
                    <p class="text-sm text-slate-600"><?php echo e($order->sender_phone); ?></p>
                    <p class="text-sm text-slate-500 mt-1"><?php echo e($order->sender_address); ?></p>
                    <p class="text-sm text-blue-500 font-medium"><?php echo e($order->sender_city); ?></p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-blue-600 mb-2">PENERIMA</p>
                    <p class="font-semibold text-slate-800"><?php echo e($order->receiver_name); ?></p>
                    <p class="text-sm text-slate-600"><?php echo e($order->receiver_phone); ?></p>
                    <p class="text-sm text-slate-500 mt-1"><?php echo e($order->receiver_address); ?></p>
                    <p class="text-sm text-blue-500 font-medium"><?php echo e($order->receiver_city); ?></p>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-slate-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-slate-400">Paket</p>
                    <p class="text-sm font-semibold text-slate-800"><?php echo e($order->package_name); ?></p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-slate-400">Berat</p>
                    <p class="text-sm font-semibold text-slate-800"><?php echo e($order->weight); ?> kg</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-slate-400">Biaya</p>
                    <p class="text-sm font-bold text-blue-600">Rp <?php echo e(number_format($order->total_cost,0,',','.')); ?></p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3 text-center">
                    <p class="text-xs text-slate-400">Est. Tiba</p>
                    <p class="text-sm font-semibold text-slate-800"><?php echo e($order->estimated_delivery?$order->estimated_delivery->format('d M Y'):'-'); ?></p>
                </div>
            </div>
        </div>
        <?php if($order->courier): ?>
        <div class="card p-5">
            <p class="text-xs font-bold text-slate-400 mb-3 uppercase">Kurir Pengiriman</p>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-motorcycle text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-800"><?php echo e($order->courier->user->name); ?></p>
                    <p class="text-xs text-slate-500"><?php echo e($order->courier->courier_code); ?> • <?php echo e($order->courier->user->phone); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="card p-6">
        <h3 class="font-semibold text-slate-800 mb-4">Tracking Pengiriman</h3>
        <div class="space-y-4">
            <?php $__currentLoopData = $order->statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex gap-3">
                <div class="flex flex-col items-center flex-shrink-0">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo e($i===0?'bg-blue-500':'bg-blue-100'); ?>">
                        <i class="fas <?php echo e($i===0?'fa-check text-white':'fa-circle text-blue-300'); ?> text-xs"></i>
                    </div>
                    <?php if(!$loop->last): ?><div class="w-0.5 h-6 bg-blue-100 mt-1"></div><?php endif; ?>
                </div>
                <div class="pb-3">
                    <p class="text-sm font-semibold text-slate-800"><?php echo e(ucfirst(str_replace('_',' ',$s->status))); ?></p>
                    <p class="text-xs text-slate-500"><?php echo e($s->description); ?></p>
                    <?php if($s->location): ?><p class="text-xs text-blue-400"><i class="fas fa-map-marker-alt mr-1"></i><?php echo e($s->location); ?></p><?php endif; ?>
                    <p class="text-xs text-slate-400"><?php echo e($s->created_at->format('d M Y, H:i')); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/customer/orders/show.blade.php ENDPATH**/ ?>