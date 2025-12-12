<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\MangaRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    // Store or update rating
    public function store(Request $request, Manga $manga)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:10',
            'review' => 'nullable|string|max:1000',
        ]);

        $rating = MangaRating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'manga_id' => $manga->id,
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        // Recalculate manga average rating
        $avgRating = $manga->ratings()->avg('rating');
        $manga->update(['rating' => round($avgRating, 1)]);

        return back()->with('success', 'Rating berhasil disimpan!');
    }

    // Show all ratings for manga
    public function index(Manga $manga)
    {
        $ratings = $manga->ratings()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('ratings.index', compact('manga', 'ratings'));
    }

    // Delete rating
    public function destroy(Manga $manga)
    {
        Auth::user()->ratings()
            ->where('manga_id', $manga->id)
            ->delete();

        // Recalculate average
        $avgRating = $manga->ratings()->avg('rating');
        $manga->update(['rating' => round($avgRating, 1)]);

        return back()->with('success', 'Rating berhasil dihapus!');
    }
}