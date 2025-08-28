<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed']); // persentase atau nominal tetap
            $table->decimal('value', 10, 2); // nilai diskon
            $table->decimal('min_purchase', 10, 2)->nullable(); // minimal pembelian
            $table->decimal('max_discount', 10, 2)->nullable(); // maksimal diskon (untuk percentage)
            $table->integer('usage_limit')->nullable(); // batas penggunaan
            $table->integer('used_count')->default(0); // jumlah sudah digunakan
            $table->integer('points_required')->nullable(); // poin yang dibutuhkan untuk menukar
            $table->datetime('valid_from');
            $table->datetime('valid_until');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
