<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('origin_zone_id')->constrained('zones');
            $table->foreignId('destination_zone_id')->constrained('zones');
            $table->enum('service_type', ['regular','express','same_day'])->default('regular');
            $table->decimal('price_per_kg', 10, 2);
            $table->decimal('min_weight', 5, 2)->default(1.00);
            $table->integer('estimated_days')->default(3);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('rates'); }
};