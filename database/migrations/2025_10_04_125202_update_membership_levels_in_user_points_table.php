<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change enum to include gold and platinum
        DB::statement("ALTER TABLE user_points MODIFY COLUMN membership_level ENUM('bronze', 'silver', 'gold', 'platinum', 'diamond') DEFAULT 'bronze'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE user_points MODIFY COLUMN membership_level ENUM('bronze', 'silver', 'diamond') DEFAULT 'bronze'");
    }
};
