<?php

namespace App\Http\Controllers;

use App\Services\MangaApiService;
use App\Support\ApiManga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(
        protected MangaApiService $api,
    ) {}

    public function index()
    {
        // --- Featured: manga rekomendasi untuk hero-slider ---
        $recommendedResponse = $this->api->getRecommended(1) ?? [];
        $recommendedList = $recommendedResponse['data'] ?? [];

        $featuredMangas = collect($recommendedList)
            ->take(5)
            ->map(fn ($item) => ApiManga::fromList($item))
            ->values();

        // --- Latest: manga terbaru ---
        $latestResponse = $this->api->getLatest(1) ?? [];
        $latestList = $latestResponse['data'] ?? [];

        $latestMangas = collect($latestList)
            ->take(8)
            ->map(fn ($item) => ApiManga::fromList($item))
            ->values();

        // --- Popular: manga populer ---
        $popularResponse = $this->api->getPopular(1) ?? [];
        $popularList = $popularResponse['data'] ?? [];

        $popularMangas = collect($popularList)
            ->take(6)
            ->map(fn ($item) => ApiManga::fromList($item))
            ->values();

        // --- Data dari database lokal (user-specific) ---

        $lastHistory = null;
        if (Auth::check()) {
            $lastHistory = Auth::user()
                ->readingHistories()
                ->with(['manga', 'manga.genres'])
                ->latest('last_read_at')
                ->first();
        }

        return view('home', compact('featuredMangas', 'latestMangas', 'popularMangas', 'lastHistory'));
    }
}