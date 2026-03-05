<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('resi_number', 30)->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('courier_id')->nullable()->constrained('couriers');
            $table->foreignId('origin_zone_id')->constrained('zones');
            $table->foreignId('destination_zone_id')->constrained('zones');
            $table->enum('service_type', ['regular','express','same_day'])->default('regular');
            $table->string('sender_name', 100);
            $table->string('sender_phone', 20);
            $table->text('sender_address');
            $table->string('sender_city', 100);
            $table->string('receiver_name', 100);
            $table->string('receiver_phone', 20);
            $table->text('receiver_address');
            $table->string('receiver_city', 100);
            $table->string('package_name', 200);
            $table->enum('package_type', ['regular','fragile','document','elektronik'])->default('regular');
            $table->decimal('weight', 8, 2);
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('insurance_cost', 12, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->enum('current_status', ['pending','pickup','in_transit','delivered','cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->date('estimated_delivery')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};