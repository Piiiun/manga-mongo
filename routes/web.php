<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ReadingHistoryController;
use App\Http\Controllers\Admin\AdminMangaController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/manga', [MangaController::class, 'index'])->name('manga.list');
Route::get('/manga/{slug}', [MangaController::class, 'show'])->name('manga.detail');
Route::get('/manga/{manga_slug}/{chapter_number}', [ChapterController::class, 'read'])->name('manga.read');
Route::get('/bookmark', [BookmarkController::class, 'index'])->name('bookmark.index');
Route::post('/bookmark/get-mangas', [BookmarkController::class, 'getMangas'])->name('bookmark.get-mangas');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('manga', AdminMangaController::class);

        Route::get('manga/{manga}/chapters', [AdminMangaController::class, 'chapters'])->name('manga.chapters');
        Route::get('manga/{manga}/chapters/create', [AdminMangaController::class, 'createChapter'])->name('manga.chapters.create');
        Route::post('manga/{manga}/chapters', [AdminMangaController::class, 'storeChapter'])->name('manga.chapters.store');
        Route::get('manga/{manga}/chapters/{chapter}/edit', [AdminMangaController::class, 'editChapter'])->name('manga.chapters.edit');
        Route::put('manga/{manga}/chapters/{chapter}', [AdminMangaController::class, 'updateChapter'])->name('manga.chapters.update');
        Route::delete('manga/{manga}/chapters/{chapter}', [AdminMangaController::class, 'destroyChapter'])->name('manga.chapters.destroy');
        Route::post('manga/{manga}/chapters/{chapter}/sync', [AdminMangaController::class, 'syncChapterImages'])->name('manga.chapters.sync');
        Route::post('manga/{manga}/chapters/sync-all', [AdminMangaController::class, 'syncAllChapters'])->name('manga.chapters.sync-all');
});

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
    
    // Reading History
    Route::get('/history', [ReadingHistoryController::class, 'index'])->name('history.index');
    Route::post('/history', [ReadingHistoryController::class, 'store'])->name('history.store');
    Route::delete('/history/{id}', [ReadingHistoryController::class, 'destroy'])->name('history.destroy');
    Route::delete('/history', [ReadingHistoryController::class, 'clear'])->name('history.clear');
});