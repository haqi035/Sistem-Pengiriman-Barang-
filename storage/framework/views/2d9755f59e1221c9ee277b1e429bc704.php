<?php $__env->startSection('title','Detail Pengiriman'); ?>
<?php $__env->startSection('page-title','Detail Pengiriman'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('courier.orders.index')); ?>" class="btn-secondary py-2 px-4 text-sm"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-bold text-blue-900"><?php echo e($order->resi_number); ?></h2>
                    <p class="text-sm text-slate-500 capitalize"><?php echo e($order->service_type); ?> • <?php echo e($order->package_type); ?></p>
                </div>
                <span class="badge-<?php echo e($order->current_status); ?> px-3 py-1.5 rounded-full text-sm font-semibold"><?php echo e($order->status_label); ?></span>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-blue-600 mb-2 uppercase">Pengirim</p>
                    <p class="font-semibold text-slate-800"><?php echo e($order->sender_name); ?></p>
                    <p class="text-sm text-slate-600"><?php echo e($order->sender_phone); ?></p>
                    <p class="text-sm text-slate-500 mt-1"><?php echo e($order->sender_address); ?></p>
                    <p class="text-sm text-blue-500 font-medium"><?php echo e($order->sender_city); ?></p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-blue-600 mb-2 uppercase">Penerima</p>
                    <p class="font-semibold text-slate-800"><?php echo e($order->receiver_name); ?></p>
                    <p class="text-sm text-slate-600"><?php echo e($order->receiver_phone); ?></p>
                    <p class="text-sm text-slate-500 mt-1"><?php echo e($order->receiver_address); ?></p>
                    <p class="text-sm text-blue-500 font-medium"><?php echo e($order->receiver_city); ?></p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-slate-50 rounded-xl p-3">
                    <p class="text-xs text-slate-400">Paket</p><p class="text-sm font-semibold text-slate-800"><?php echo e($order->package_name); ?></p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3">
                    <p class="text-xs text-slate-400">Berat</p><p class="text-sm font-semibold text-slate-800"><?php echo e($order->weight); ?> kg</p>
                </div>
            </div>
        </div>

        <?php if(!in_array($order->current_status,['delivered','cancelled'])): ?>
        <div class="card p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Update Status</h3>
            <form method="POST" action="<?php echo e(route('courier.orders.updateStatus',$order)); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div><label class="block text-sm font-medium text-slate-700 mb-2">Status Baru</label>
                <select name="status" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                    <option value="pickup" <?php echo e($order->current_status=='pickup'?'selected':''); ?>>Pickup - Ambil Paket</option>
                    <option value="in_transit" <?php echo e($order->current_status=='in_transit'?'selected':''); ?>>Dalam Perjalanan</option>
                    <option value="delivered" >Terkirim - Paket Diterima</option>
                    <option value="cancelled" >Dibatalkan</option>
                </select></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-2">Lokasi Saat Ini</label>
                <input type="text" name="location" placeholder="Contoh: Gudang Jakarta" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-2">Keterangan <span class="text-red-400">*</span></label>
                <input type="text" name="description" required placeholder="Contoh: Paket berhasil diambil dari pengirim" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
                <button type="submit" class="btn-primary w-full justify-center flex items-center gap-2"><i class="fas fa-save"></i>Update Status</button>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <div class="card p-6">
        <h3 class="font-semibold text-slate-800 mb-4">Riwayat Status</h3>
        <div class="space-y-4">
            <?php $__currentLoopData = $order->statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex gap-3">
                <div class="flex flex-col items-center flex-shrink-0">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center <?php echo e($loop->first?'bg-blue-500':'bg-blue-100'); ?>">
                        <i class="fas <?php echo e($loop->first?'fa-check text-white':'fa-circle text-blue-300'); ?> text-xs"></i>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/courier/orders/show.blade.php ENDPATH**/ ?>