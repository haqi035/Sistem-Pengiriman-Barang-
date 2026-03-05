<?php $__env->startSection('title','Login'); ?>
<?php $__env->startSection('content'); ?>
<div class="text-center mb-8">
    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg mx-auto mb-4">
        <i class="fas fa-shipping-fast text-white text-2xl"></i>
    </div>
    <h1 class="text-2xl font-bold text-blue-900">ShipEasy</h1>
    <p class="text-slate-500 text-sm mt-1">Sistem Manajemen Pengiriman</p>
</div>
<div class="bg-white rounded-2xl shadow-xl border border-blue-50 p-8">
    <h2 class="text-xl font-semibold text-slate-800 mb-6">Masuk ke Akun</h2>
    <?php if($errors->any()): ?>
    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <i class="fas fa-exclamation-circle"></i><span><?php echo e($errors->first()); ?></span>
    </div>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
        <?php echo csrf_field(); ?>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-blue-300 text-sm"></i>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="admin@shipper.com"
                    class="w-full pl-10 pr-4 py-3 border border-blue-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 text-sm bg-blue-50/30">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-blue-300 text-sm"></i>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full pl-10 pr-4 py-3 border border-blue-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 text-sm bg-blue-50/30">
            </div>
        </div>
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-blue-200 text-blue-500">
                <span>Ingat saya</span>
            </label>
        </div>
        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 rounded-xl transition shadow-md shadow-blue-200 flex items-center justify-center gap-2">
            <i class="fas fa-sign-in-alt"></i><span>Masuk</span>
        </button>
    </form>
    <div class="mt-6 p-4 bg-blue-50 rounded-xl space-y-1">
        <p class="text-xs font-bold text-blue-600 mb-1">Demo Akun (password: password)</p>
        <p class="text-xs text-slate-600"><span class="font-medium">Admin:</span> admin@shipper.com</p>
        <p class="text-xs text-slate-600"><span class="font-medium">Kurir:</span> kurir@shipper.com</p>
        <p class="text-xs text-slate-600"><span class="font-medium">Customer:</span> customer@shipper.com</p>
    </div>
</div>
<div class="text-center mt-4">
    <a href="<?php echo e(route('tracking')); ?>" class="text-sm text-blue-500 hover:text-blue-700 font-medium">
        <i class="fas fa-search-location mr-1"></i>Lacak Paket Tanpa Login
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/auth/login.blade.php ENDPATH**/ ?>