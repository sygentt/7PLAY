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
        Schema::table('vouchers', function (Blueprint $table) {
            if (Schema::hasColumn('vouchers', 'code')) {
                $table->dropUnique(['code']);
                $table->dropColumn('code');
            }
            if (Schema::hasColumn('vouchers', 'usage_limit')) {
                $table->dropColumn('usage_limit');
            }
            if (Schema::hasColumn('vouchers', 'used_count')) {
                $table->dropColumn('used_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            if (!Schema::hasColumn('vouchers', 'code')) {
                $table->string('code')->unique();
            }
            if (!Schema::hasColumn('vouchers', 'usage_limit')) {
                $table->integer('usage_limit')->nullable();
            }
            if (!Schema::hasColumn('vouchers', 'used_count')) {
                $table->integer('used_count')->default(0);
            }
        });
    }
};
