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
        Schema::table('reading_histories', function (Blueprint $table) {
            // Make manga_id nullable (API-backed manga may not have a local DB row)
            $table->dropForeign(['manga_id']);
            $table->unsignedBigInteger('manga_id')->nullable()->change();
            $table->foreign('manga_id')->references('id')->on('mangas')->onDelete('cascade');

            // API metadata columns so history can render without extra API calls
            $table->string('api_manga_id')->nullable()->after('manga_id');
            $table->string('title')->nullable()->after('api_manga_id');
            $table->string('cover_image')->nullable()->after('title');
            $table->string('author')->nullable()->after('cover_image');
            $table->string('status')->nullable()->after('author');
            $table->string('type')->nullable()->after('status');
            $table->float('rating')->nullable()->after('type');

            $table->index('api_manga_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reading_histories', function (Blueprint $table) {
            $table->dropIndex(['api_manga_id']);
            $table->dropColumn(['api_manga_id', 'title', 'cover_image', 'author', 'status', 'type', 'rating']);
            $table->dropForeign(['manga_id']);
            $table->unsignedBigInteger('manga_id')->nullable(false)->change();
            $table->foreign('manga_id')->references('id')->on('mangas')->onDelete('cascade');
        });
    }
};
