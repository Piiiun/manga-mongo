<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('chapter_number')->nullable()->after('chapter_id');
            $table->index(['manga_id', 'chapter_number']);
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['manga_id', 'chapter_number']);
            $table->dropColumn('chapter_number');
        });
    }
};
