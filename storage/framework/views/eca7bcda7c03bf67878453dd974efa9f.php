<?php $__env->startSection('title','Tarif'); ?>
<?php $__env->startSection('page-title','Kelola Tarif'); ?>
<?php $__env->startSection('content'); ?>
<div class="card p-6">
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-slate-500">Daftar tarif pengiriman per zona</p>
        <a href="<?php echo e(route('admin.rates.create')); ?>" class="btn-primary flex items-center gap-2"><i class="fas fa-plus"></i><span>Tambah Tarif</span></a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-50">
                <th class="pb-3 pr-4">Asal → Tujuan</th><th class="pb-3 pr-4">Layanan</th>
                <th class="pb-3 pr-4">Harga/kg</th><th class="pb-3 pr-4">Min. Berat</th>
                <th class="pb-3 pr-4">Est. Hari</th><th class="pb-3 pr-4">Status</th><th class="pb-3">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-blue-50">
                <?php $__empty_1 = true; $__currentLoopData = $rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-blue-50/30 transition">
                    <td class="py-3.5 pr-4">
                        <p class="text-sm font-medium text-slate-700"><?php echo e($r->originZone->city); ?></p>
                        <p class="text-xs text-slate-400">→ <?php echo e($r->destinationZone->city); ?></p>
                    </td>
                    <td class="py-3.5 pr-4">
                        <span class="<?php echo e($r->service_type=='express'?'bg-orange-100 text-orange-600':($r->service_type=='same_day'?'bg-red-100 text-red-600':'bg-blue-100 text-blue-600')); ?> px-2.5 py-1 rounded-full text-xs font-semibold capitalize">
                            <?php echo e($r->service_type); ?>

                        </span>
                    </td>
                    <td class="py-3.5 pr-4 text-sm font-semibold text-slate-700">Rp <?php echo e(number_format($r->price_per_kg,0,',','.')); ?></td>
                    <td class="py-3.5 pr-4 text-sm text-slate-600"><?php echo e($r->min_weight); ?> kg</td>
                    <td class="py-3.5 pr-4 text-sm text-slate-600"><?php echo e($r->estimated_days); ?> hari</td>
                    <td class="py-3.5 pr-4">
                        <span class="<?php echo e($r->is_active?'bg-green-100 text-green-600':'bg-red-100 text-red-500'); ?> px-2.5 py-1 rounded-full text-xs font-semibold">
                            <?php echo e($r->is_active?'Aktif':'Nonaktif'); ?>

                        </span>
                    </td>
                    <td class="py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route('admin.rates.edit',$r)); ?>" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="<?php echo e(route('admin.rates.destroy',$r)); ?>" onsubmit="return confirm('Hapus tarif ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="py-12 text-center text-slate-400 text-sm">Belum ada tarif</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($rates->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/admin/rates/index.blade.php ENDPATH**/ ?>