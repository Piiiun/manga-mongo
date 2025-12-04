<?php

namespace App\Http\Controllers;
use App\Models\Manga;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredMangas = Manga::with('genres')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $latestMangas = Manga::with([
                'genres',
                'chapters' => fn ($q) => $q->orderByDesc('number')->take(3),
            ])
            ->orderByDesc('updated_at')   // atau 'created_at'
            ->take(8)
            ->get();

        $popularMangas = Manga::with(['genres', 'chapters'])
        ->withCount('chapters')
        ->orderBy('views', 'desc')
        ->take(6)
        ->get();

        return view('home', compact('featuredMangas', 'latestMangas', 'popularMangas'));
    }
}