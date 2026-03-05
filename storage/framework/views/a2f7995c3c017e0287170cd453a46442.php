<?php $__env->startSection('title','Kelola Order'); ?>
<?php $__env->startSection('page-title','Kelola Order'); ?>
<?php $__env->startSection('content'); ?>
<div class="card p-6">
    
    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <div class="relative flex-1 min-w-48">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-blue-300 text-sm"></i>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari resi, pengirim, penerima..."
                class="w-full pl-9 pr-4 py-2.5 border border-blue-100 rounded-xl text-sm bg-blue-50/30 focus:outline-none focus:ring-2 focus:ring-blue-200">
        </div>
        <select name="status" class="border border-blue-100 rounded-xl px-4 py-2.5 text-sm bg-blue-50/30 focus:outline-none focus:ring-2 focus:ring-blue-200">
            <option value="">Semua Status</option>
            <option value="pending" <?php echo e(request('status')=='pending'?'selected':''); ?>>Pending</option>
            <option value="pickup" <?php echo e(request('status')=='pickup'?'selected':''); ?>>Pickup</option>
            <option value="in_transit" <?php echo e(request('status')=='in_transit'?'selected':''); ?>>Dalam Perjalanan</option>
            <option value="delivered" <?php echo e(request('status')=='delivered'?'selected':''); ?>>Terkirim</option>
            <option value="cancelled" <?php echo e(request('status')=='cancelled'?'selected':''); ?>>Dibatalkan</option>
        </select>
        <button type="submit" class="btn-primary">Filter</button>
        <?php if(request()->hasAny(['search','status','service'])): ?>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn-secondary">Reset</a>
        <?php endif; ?>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-50">
                    <th class="pb-3 pr-4">Resi</th><th class="pb-3 pr-4">Pengirim → Penerima</th>
                    <th class="pb-3 pr-4">Kurir</th><th class="pb-3 pr-4">Biaya</th>
                    <th class="pb-3 pr-4">Status</th><th class="pb-3 pr-4">Tanggal</th><th class="pb-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-50">
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-blue-50/30 transition">
                    <td class="py-3.5 pr-4">
                        <a href="<?php echo e(route('admin.orders.show',$o)); ?>" class="text-sm font-semibold text-blue-600 hover:text-blue-800"><?php echo e($o->resi_number); ?></a>
                        <p class="text-xs text-slate-400 capitalize"><?php echo e($o->service_type); ?></p>
                    </td>
                    <td class="py-3.5 pr-4">
                        <p class="text-sm font-medium text-slate-700"><?php echo e($o->sender_name); ?></p>
                        <p class="text-xs text-slate-400">→ <?php echo e($o->receiver_name); ?></p>
                        <p class="text-xs text-blue-400"><?php echo e($o->destinationZone->city ?? '-'); ?></p>
                    </td>
                    <td class="py-3.5 pr-4 text-sm text-slate-600">
                        <?php echo e($o->courier->user->name ?? '<span class="text-orange-400 text-xs">Belum ditugaskan</span>'); ?>

                    </td>
                    <td class="py-3.5 pr-4 text-sm font-semibold text-slate-700">Rp <?php echo e(number_format($o->total_cost,0,',','.')); ?></td>
                    <td class="py-3.5 pr-4">
                        <span class="badge-<?php echo e($o->current_status); ?> px-2.5 py-1 rounded-full text-xs font-semibold"><?php echo e($o->status_label); ?></span>
                    </td>
                    <td class="py-3.5 pr-4 text-xs text-slate-400"><?php echo e($o->created_at->format('d M Y')); ?></td>
                    <td class="py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route('admin.orders.show',$o)); ?>" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-eye"></i></a>
                            <form method="POST" action="<?php echo e(route('admin.orders.destroy',$o)); ?>" onsubmit="return confirm('Hapus order ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="py-12 text-center text-slate-400">
                    <i class="fas fa-inbox text-3xl mb-2 block text-blue-200"></i>Tidak ada order ditemukan
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($orders->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>