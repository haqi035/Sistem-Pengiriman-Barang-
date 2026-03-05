<?php $__env->startSection('title','Kirim Paket'); ?>
<?php $__env->startSection('page-title','Form Pengiriman Paket'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-3xl">
<form method="POST" action="<?php echo e(route('customer.orders.store')); ?>" class="space-y-6" id="orderForm">
    <?php echo csrf_field(); ?>

    
    <div class="card p-6">
        <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
            <span class="w-7 h-7 bg-blue-500 text-white rounded-full text-xs flex items-center justify-center font-bold">1</span>
            Rute & Jenis Layanan
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Zona Asal <span class="text-red-400">*</span></label>
                <select name="origin_zone_id" id="origin" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                    <option value="">Pilih Zona Asal</option>
                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($z->id); ?>" <?php echo e(old('origin_zone_id')==$z->id?'selected':''); ?>><?php echo e($z->city); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['origin_zone_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Zona Tujuan <span class="text-red-400">*</span></label>
                <select name="destination_zone_id" id="dest" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                    <option value="">Pilih Zona Tujuan</option>
                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($z->id); ?>" <?php echo e(old('destination_zone_id')==$z->id?'selected':''); ?>><?php echo e($z->city); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['destination_zone_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Layanan <span class="text-red-400">*</span></label>
                <select name="service_type" id="service" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                    <option value="regular" <?php echo e(old('service_type','regular')=='regular'?'selected':''); ?>>Regular</option>
                    <option value="express" <?php echo e(old('service_type')=='express'?'selected':''); ?>>Express</option>
                    <option value="same_day" <?php echo e(old('service_type')=='same_day'?'selected':''); ?>>Same Day</option>
                </select>
            </div>
        </div>
        
        <div id="rateInfo" class="mt-4 hidden">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-xs text-blue-500 font-medium">Estimasi Biaya</p>
                    <p class="text-xl font-bold text-blue-700" id="rateDisplay">-</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500">Estimasi Tiba</p>
                    <p class="text-sm font-semibold text-slate-700" id="etaDisplay">-</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card p-6">
        <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
            <span class="w-7 h-7 bg-blue-500 text-white rounded-full text-xs flex items-center justify-center font-bold">2</span>
            Data Pengirim
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Nama Pengirim <span class="text-red-400">*</span></label>
            <input type="text" name="sender_name" value="<?php echo e(old('sender_name',auth()->user()->name)); ?>" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">No. HP Pengirim <span class="text-red-400">*</span></label>
            <input type="text" name="sender_phone" value="<?php echo e(old('sender_phone',auth()->user()->phone)); ?>" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div class="md:col-span-2"><label class="block text-sm font-medium text-slate-700 mb-2">Alamat Pengirim <span class="text-red-400">*</span></label>
            <textarea name="sender_address" required rows="2" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30 resize-none"><?php echo e(old('sender_address')); ?></textarea></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Kota Pengirim <span class="text-red-400">*</span></label>
            <input type="text" name="sender_city" value="<?php echo e(old('sender_city')); ?>" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
        </div>
    </div>

    
    <div class="card p-6">
        <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
            <span class="w-7 h-7 bg-blue-500 text-white rounded-full text-xs flex items-center justify-center font-bold">3</span>
            Data Penerima
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Nama Penerima <span class="text-red-400">*</span></label>
            <input type="text" name="receiver_name" value="<?php echo e(old('receiver_name')); ?>" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">No. HP Penerima <span class="text-red-400">*</span></label>
            <input type="text" name="receiver_phone" value="<?php echo e(old('receiver_phone')); ?>" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div class="md:col-span-2"><label class="block text-sm font-medium text-slate-700 mb-2">Alamat Penerima <span class="text-red-400">*</span></label>
            <textarea name="receiver_address" required rows="2" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30 resize-none"><?php echo e(old('receiver_address')); ?></textarea></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Kota Penerima <span class="text-red-400">*</span></label>
            <input type="text" name="receiver_city" value="<?php echo e(old('receiver_city')); ?>" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
        </div>
    </div>

    
    <div class="card p-6">
        <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
            <span class="w-7 h-7 bg-blue-500 text-white rounded-full text-xs flex items-center justify-center font-bold">4</span>
            Detail Paket
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Nama Paket <span class="text-red-400">*</span></label>
            <input type="text" name="package_name" value="<?php echo e(old('package_name')); ?>" required placeholder="Contoh: Baju Batik" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Jenis Paket <span class="text-red-400">*</span></label>
            <select name="package_type" required class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30">
                <option value="regular" <?php echo e(old('package_type','regular')=='regular'?'selected':''); ?>>Regular</option>
                <option value="fragile" <?php echo e(old('package_type')=='fragile'?'selected':''); ?>>Fragile (Mudah Pecah)</option>
                <option value="document" <?php echo e(old('package_type')=='document'?'selected':''); ?>>Dokumen</option>
                <option value="elektronik" <?php echo e(old('package_type')=='elektronik'?'selected':''); ?>>Elektronik</option>
            </select></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Berat (kg) <span class="text-red-400">*</span></label>
            <input type="number" name="weight" id="weight" value="<?php echo e(old('weight',1)); ?>" required min="0.1" step="0.1" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
            <input type="text" name="notes" value="<?php echo e(old('notes')); ?>" placeholder="Opsional" class="w-full border border-blue-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 bg-blue-50/30"></div>
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-primary flex items-center gap-2 px-8">
            <i class="fas fa-paper-plane"></i><span>Buat Order</span>
        </button>
        <a href="<?php echo e(route('customer.orders.index')); ?>" class="btn-secondary">Batal</a>
    </div>
</form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
function getRate() {
    const o = document.getElementById('origin').value;
    const d = document.getElementById('dest').value;
    const s = document.getElementById('service').value;
    const w = document.getElementById('weight').value;
    if (!o || !d || !s) return;
    fetch(`<?php echo e(route('customer.orders.getRate')); ?>?origin=${o}&destination=${d}&service=${s}&weight=${w}`)
        .then(r => r.json()).then(data => {
            if (data.error) { document.getElementById('rateInfo').classList.add('hidden'); return; }
            document.getElementById('rateDisplay').textContent = data.formatted_cost;
            document.getElementById('etaDisplay').textContent = data.estimated_days + ' hari';
            document.getElementById('rateInfo').classList.remove('hidden');
        }).catch(() => document.getElementById('rateInfo').classList.add('hidden'));
}
['origin','dest','service','weight'].forEach(id => {
    document.getElementById(id).addEventListener('change', getRate);
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/customer/orders/create.blade.php ENDPATH**/ ?>