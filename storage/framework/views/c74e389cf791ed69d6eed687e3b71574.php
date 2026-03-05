<?php $__env->startSection('title','Zona Wilayah'); ?>
<?php $__env->startSection('page-title','Zona Wilayah'); ?>
<?php $__env->startSection('content'); ?>
<div class="card p-6">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <form method="GET" class="flex gap-3 flex-1">
            <div class="relative flex-1 min-w-48">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-blue-300 text-sm"></i>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari kota atau provinsi..."
                    class="w-full pl-9 pr-4 py-2.5 border border-blue-100 rounded-xl text-sm bg-blue-50/30 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>
            <button type="submit" class="btn-primary">Cari</button>
        </form>
        <a href="<?php echo e(route('admin.zones.create')); ?>" class="btn-primary flex items-center gap-2"><i class="fas fa-plus"></i><span>Tambah Zona</span></a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-50">
                <th class="pb-3 pr-4">Nama Zona</th><th class="pb-3 pr-4">Provinsi</th><th class="pb-3 pr-4">Kota</th>
                <th class="pb-3 pr-4">Kode Pos</th><th class="pb-3 pr-4">Status</th><th class="pb-3">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-blue-50">
                <?php $__empty_1 = true; $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-blue-50/30 transition">
                    <td class="py-3.5 pr-4 text-sm font-medium text-slate-700"><?php echo e($z->name); ?></td>
                    <td class="py-3.5 pr-4 text-sm text-slate-600"><?php echo e($z->province); ?></td>
                    <td class="py-3.5 pr-4 text-sm text-slate-600"><?php echo e($z->city); ?></td>
                    <td class="py-3.5 pr-4 text-sm text-slate-500"><?php echo e($z->postal_code??'-'); ?></td>
                    <td class="py-3.5 pr-4">
                        <span class="<?php echo e($z->is_active?'bg-green-100 text-green-600':'bg-red-100 text-red-500'); ?> px-2.5 py-1 rounded-full text-xs font-semibold">
                            <?php echo e($z->is_active?'Aktif':'Nonaktif'); ?>

                        </span>
                    </td>
                    <td class="py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route('admin.zones.edit',$z)); ?>" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="<?php echo e(route('admin.zones.destroy',$z)); ?>" onsubmit="return confirm('Hapus zona ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="py-12 text-center text-slate-400 text-sm">Belum ada zona</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($zones->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/admin/zones/index.blade.php ENDPATH**/ ?>