<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\Admin\AdminMangaController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/read', function () {
//     return view('home');
// });
// Route::get('/bookmark', function () {
//     return view('home');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/manga', [MangaController::class, 'index'])->name('manga.list');
Route::get('/manga/{slug}', [MangaController::class, 'show'])->name('manga.detail');
Route::get('/manga/{manga_slug}/{chapter_number}', [ChapterController::class, 'read'])->name('manga.read');

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Manga Management
    Route::resource('manga', AdminMangaController::class);
    
    // Chapter Management
    Route::get('manga/{manga}/chapters', [AdminMangaController::class, 'chapters'])->name('manga.chapters');
    Route::get('manga/{manga}/chapters/create', [AdminMangaController::class, 'createChapter'])->name('manga.chapters.create');
    Route::post('manga/{manga}/chapters', [AdminMangaController::class, 'storeChapter'])->name('manga.chapters.store');
    Route::get('manga/{manga}/chapters/{chapter}/edit', [AdminMangaController::class, 'editChapter'])->name('manga.chapters.edit');
    Route::put('manga/{manga}/chapters/{chapter}', [AdminMangaController::class, 'updateChapter'])->name('manga.chapters.update');
    Route::delete('manga/{manga}/chapters/{chapter}', [AdminMangaController::class, 'destroyChapter'])->name('manga.chapters.destroy');
    Route::post('manga/{manga}/chapters/{chapter}/sync', [AdminMangaController::class, 'syncChapterImages'])->name('manga.chapters.sync');
    Route::post('manga/{manga}/chapters/sync-all', [AdminMangaController::class, 'syncAllChapters'])->name('manga.chapters.sync-all');
});