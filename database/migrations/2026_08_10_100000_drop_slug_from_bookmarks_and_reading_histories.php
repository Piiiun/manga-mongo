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
            $table->dropColumn('slug');
        });

        Schema::table('reading_histories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('api_manga_id');
        });

        Schema::table('reading_histories', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('api_manga_id');
        });
    }
};
