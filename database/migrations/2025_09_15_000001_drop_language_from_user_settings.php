<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('user_settings') && Schema::hasColumn('user_settings', 'language')) {
            Schema::table('user_settings', function (Blueprint $table) {
                $table->dropColumn('language');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('user_settings') && ! Schema::hasColumn('user_settings', 'language')) {
            Schema::table('user_settings', function (Blueprint $table) {
                $table->string('language', 5)->default('id');
            });
        }
    }
};


