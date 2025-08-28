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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('synopsis');
            $table->string('genre');
            $table->integer('duration'); // dalam menit
            $table->string('rating'); // SU, 13+, 17+, dll
            $table->string('language');
            $table->string('poster_url')->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('director');
            $table->json('cast'); // array nama pemain
            $table->date('release_date');
            $table->enum('status', ['coming_soon', 'now_playing', 'finished'])->default('coming_soon');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
