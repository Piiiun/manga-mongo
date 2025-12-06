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
        Schema::create('mangas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('alternative_title')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('author')->nullable();
            $table->string('artist')->nullable();
            $table->enum('status', ['Ongoing', 'Completed'])->default('Ongoing');
            $table->string('type')->default('Manga');
            $table->float('rating')->default(0);
            $table->year('released_at')->nullable();
            $table->string('serialization')->nullable();
            $table->unsignedInteger('total_chapters')->default(0);
            $table->timestamp('last_update')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangas');
    }
};