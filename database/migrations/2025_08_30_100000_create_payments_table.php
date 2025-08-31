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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->index();
            $table->string('external_id')->unique()->comment('Unique identifier for Midtrans');
            $table->string('reference_no')->nullable()->comment('Midtrans reference number');
            $table->string('merchant_id');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('IDR');
            $table->string('payment_method')->nullable()->comment('qris, gopay, dana, etc');
            $table->string('payment_type')->default('qris');
            $table->text('qr_code_url')->nullable()->comment('QR Code URL for QRIS');
            $table->text('deep_link_url')->nullable()->comment('Deep link URL for mobile apps');
            $table->string('status')->default('pending')->comment('pending, settlement, deny, cancel, expire, failure');
            $table->string('fraud_status')->nullable()->comment('accept, challenge, deny');
            $table->timestamp('transaction_time')->nullable();
            $table->timestamp('settlement_time')->nullable();
            $table->timestamp('expiry_time')->nullable();
            $table->json('customer_details')->nullable();
            $table->json('item_details')->nullable();
            $table->json('metadata')->nullable()->comment('Additional data from order');
            $table->json('raw_response')->nullable()->comment('Raw response from Midtrans');
            $table->timestamps();

            // Indexes untuk performa
            $table->index(['status', 'created_at']);
            $table->index(['payment_method', 'status']);
            $table->index('expiry_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
