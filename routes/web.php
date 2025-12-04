<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MangaController;

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