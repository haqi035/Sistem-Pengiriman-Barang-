<?php $__env->startSection('title','Pelanggan'); ?>
<?php $__env->startSection('page-title','Data Pelanggan'); ?>
<?php $__env->startSection('content'); ?>
<div class="card p-6">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <form method="GET" class="flex gap-3 flex-1">
            <div class="relative flex-1 min-w-48">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-blue-300 text-sm"></i>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama atau email..."
                    class="w-full pl-9 pr-4 py-2.5 border border-blue-100 rounded-xl text-sm bg-blue-50/30 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>
            <button type="submit" class="btn-primary">Cari</button>
        </form>
        <a href="<?php echo e(route('admin.customers.create')); ?>" class="btn-primary flex items-center gap-2">
            <i class="fas fa-plus"></i><span>Tambah</span>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-blue-50">
                <th class="pb-3 pr-4">Nama</th><th class="pb-3 pr-4">Email</th><th class="pb-3 pr-4">No. HP</th>
                <th class="pb-3 pr-4">Total Order</th><th class="pb-3 pr-4">Status</th><th class="pb-3">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-blue-50">
                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-blue-50/30 transition">
                    <td class="py-3.5 pr-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-xs font-bold"><?php echo e(strtoupper(substr($c->name,0,2))); ?></span>
                            </div>
                            <span class="text-sm font-medium text-slate-700"><?php echo e($c->name); ?></span>
                        </div>
                    </td>
                    <td class="py-3.5 pr-4 text-sm text-slate-600"><?php echo e($c->email); ?></td>
                    <td class="py-3.5 pr-4 text-sm text-slate-600"><?php echo e($c->phone??'-'); ?></td>
                    <td class="py-3.5 pr-4 text-sm font-semibold text-blue-600"><?php echo e($c->orders_count); ?> order</td>
                    <td class="py-3.5 pr-4">
                        <span class="<?php echo e($c->is_active?'bg-green-100 text-green-600':'bg-red-100 text-red-500'); ?> px-2.5 py-1 rounded-full text-xs font-semibold">
                            <?php echo e($c->is_active?'Aktif':'Nonaktif'); ?>

                        </span>
                    </td>
                    <td class="py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route('admin.customers.edit',$c)); ?>" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="<?php echo e(route('admin.customers.destroy',$c)); ?>" onsubmit="return confirm('Hapus pelanggan ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="py-12 text-center text-slate-400 text-sm">Belum ada pelanggan</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($customers->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/admin/customers/index.blade.php ENDPATH**/ ?>