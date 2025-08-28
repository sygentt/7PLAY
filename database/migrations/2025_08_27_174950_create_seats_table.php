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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_hall_id')->constrained()->onDelete('cascade');
            $table->string('row_label'); // A, B, C, dll
            $table->integer('seat_number'); // 1, 2, 3, dll
            $table->enum('type', ['regular', 'premium', 'wheelchair'])->default('regular');
            $table->boolean('is_active')->default(true);
            $table->unique(['cinema_hall_id', 'row_label', 'seat_number']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
