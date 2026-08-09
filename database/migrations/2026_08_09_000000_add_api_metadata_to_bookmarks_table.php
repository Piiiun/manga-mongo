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
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->dropForeign(['manga_id']);
            $table->unsignedBigInteger('manga_id')->nullable()->change();
            $table->foreign('manga_id')->references('id')->on('mangas')->onDelete('cascade');

            $table->string('api_manga_id')->nullable()->after('manga_id');
            $table->string('slug')->nullable()->after('api_manga_id');
            $table->string('title')->nullable()->after('slug');
            $table->string('cover_image')->nullable()->after('title');
            $table->string('author')->nullable()->after('cover_image');
            $table->string('status')->nullable()->after('author');
            $table->string('type')->nullable()->after('status');
            $table->float('rating')->nullable()->after('type');
            $table->text('description')->nullable()->after('rating');
            $table->string('source')->default('local')->after('description');

            $table->unique(['user_id', 'api_manga_id']);
            $table->index('api_manga_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->dropUnique(['bookmarks_user_id_api_manga_id_unique']);
            $table->dropIndex(['api_manga_id']);
            $table->dropColumn(['api_manga_id', 'slug', 'title', 'cover_image', 'author', 'status', 'type', 'rating', 'description', 'source']);
            $table->dropForeign(['manga_id']);
            $table->unsignedBigInteger('manga_id')->nullable(false)->change();
            $table->foreign('manga_id')->references('id')->on('mangas')->onDelete('cascade');
        });
    }
};
