<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Paket - ShipEasy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body{font-family:'Plus Jakarta Sans',sans-serif;}
    .badge-pending{background:#fef3c7;color:#d97706;}.badge-pickup{background:#dbeafe;color:#2563eb;}
    .badge-in_transit{background:#e0f2fe;color:#0284c7;}.badge-delivered{background:#dcfce7;color:#16a34a;}
    .badge-cancelled{background:#fee2e2;color:#dc2626;}</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-white">
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="text-center mb-10">
        <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center gap-2 mb-6 font-bold text-xl text-blue-700">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center"><i class="fas fa-shipping-fast text-white"></i></div>
            ShipEasy
        </a>
        <h1 class="text-3xl font-bold text-blue-900">Lacak Pengiriman</h1>
        <p class="text-slate-500 mt-2">Masukkan nomor resi untuk melacak paket Anda</p>
    </div>
    <div class="bg-white rounded-2xl shadow-xl border border-blue-50 p-8">
        <form method="GET" action="<?php echo e(route('tracking')); ?>" class="flex gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-barcode absolute left-3 top-1/2 -translate-y-1/2 text-blue-300"></i>
                <input type="text" name="resi" value="<?php echo e(request('resi')); ?>" placeholder="Contoh: SHP-20240101-0001"
                    class="w-full pl-10 pr-4 py-3.5 border border-blue-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 text-sm bg-blue-50/30">
            </div>
            <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3.5 rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transition shadow-md shadow-blue-200">
                Lacak
            </button>
        </form>

        <?php if(isset($order) && $order): ?>
        <div class="mt-8 border-t border-blue-50 pt-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-xs text-slate-500 font-medium">Nomor Resi</p>
                    <p class="text-lg font-bold text-blue-900"><?php echo e($order->resi_number); ?></p>
                </div>
                <span class="badge-<?php echo e($order->current_status); ?> px-3 py-1.5 rounded-full text-xs font-semibold">
                    <?php echo e($order->status_label); ?>

                </span>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-xs text-slate-500 mb-1 font-medium">Pengirim</p>
                    <p class="text-sm font-semibold text-slate-800"><?php echo e($order->sender_name); ?></p>
                    <p class="text-xs text-slate-500"><?php echo e($order->sender_city); ?></p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-xs text-slate-500 mb-1 font-medium">Penerima</p>
                    <p class="text-sm font-semibold text-slate-800"><?php echo e($order->receiver_name); ?></p>
                    <p class="text-xs text-slate-500"><?php echo e($order->receiver_city); ?></p>
                </div>
            </div>
            <div class="space-y-1">
                <h3 class="font-semibold text-slate-800 text-sm mb-4">Riwayat Status</h3>
                <?php $__currentLoopData = $order->statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex gap-4 pb-4">
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 <?php echo e($i===0?'bg-blue-500':'bg-blue-100'); ?>">
                            <i class="fas <?php echo e($i===0?'fa-check text-white':'fa-circle text-blue-300'); ?> text-xs"></i>
                        </div>
                        <?php if(!$loop->last): ?><div class="w-0.5 flex-1 bg-blue-100 mt-1"></div><?php endif; ?>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800"><?php echo e(ucfirst(str_replace('_',' ',$status->status))); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($status->description); ?></p>
                        <?php if($status->location): ?><p class="text-xs text-blue-400 mt-0.5"><i class="fas fa-map-marker-alt mr-1"></i><?php echo e($status->location); ?></p><?php endif; ?>
                        <p class="text-xs text-slate-400 mt-0.5"><?php echo e($status->created_at->format('d M Y, H:i')); ?> WIB</p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php elseif(request('resi')): ?>
        <div class="mt-6 text-center py-8">
            <i class="fas fa-search text-3xl text-blue-200 mb-3 block"></i>
            <p class="text-slate-500 font-medium">Resi tidak ditemukan</p>
            <p class="text-sm text-slate-400">Periksa kembali nomor resi Anda</p>
        </div>
        <?php endif; ?>
    </div>
    <div class="text-center mt-6">
        <a href="<?php echo e(route('login')); ?>" class="text-sm text-blue-500 hover:text-blue-700 font-medium">
            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Login
        </a>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\Baihaqi\Documents\sistem_pengiriman\resources\views/tracking.blade.php ENDPATH**/ ?>