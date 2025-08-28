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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('showtime_id')->constrained()->onDelete('cascade');
            $table->foreignId('voucher_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->integer('points_earned')->default(0);
            $table->integer('points_used')->default(0);
            $table->enum('status', ['pending', 'paid', 'confirmed', 'cancelled'])->default('pending');
            $table->string('payment_method')->nullable(); // midtrans, qris, dll
            $table->string('payment_reference')->nullable(); // reference dari payment gateway
            $table->json('payment_data')->nullable(); // data payment dari midtrans
            $table->string('qr_code')->nullable(); // QR code untuk e-ticket
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('expiry_date')->nullable(); // batas waktu pembayaran
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['order_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
