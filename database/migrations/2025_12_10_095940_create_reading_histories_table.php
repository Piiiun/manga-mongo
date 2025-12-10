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
        Schema::create('reading_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('manga_id')->constrained()->onDelete('cascade');
            $table->integer('chapter_number');
            $table->integer('last_page')->default(1);
            $table->timestamp('last_read_at');
            $table->timestamps();
            
            $table->index(['user_id', 'manga_id']);
            $table->index('last_read_at');
            
            $table->unique(['user_id', 'manga_id', 'chapter_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reading_histories');
    }
};
