<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Halaman utama bookmark (menampilkan view).
     */
    public function page()
    {
        return view('bookmark');
    }
    
    /**
     * API untuk ambil data manga berdasarkan IDs dari localStorage (mode guest).
     */
    public function getMangas(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return response()->json(['mangas' => []]);
        }
        
        $mangas = Manga::whereIn('id', $ids)
            ->select('id', 'title', 'slug', 'cover_image', 'author', 'rating', 'status')
            ->get()
            ->map(function($manga) {
                $manga->cover_image = $manga->cover_image
                    ? asset('storage/manga/' . $manga->cover_image)
                    : asset('images/no-cover.jpg');
                return $manga;
            });
        
        return response()->json(['mangas' => $mangas]);
    }

    /**
     * Ambil daftar bookmark milik user yang sedang login.
     */
    public function index()
    {
        $userId = Auth::id();

        $bookmarks = Bookmark::where('user_id', $userId)
            ->pluck('manga_id')
            ->values();

        return response()->json([
            'bookmarks' => $bookmarks,
        ]);
    }

    /**
     * Tambah / hapus bookmark untuk user login.
     */
    public function toggle(Request $request)
    {
        $data = $request->validate([
            'manga_id' => ['required', 'integer', 'exists:mangas,id'],
        ]);

        $userId = Auth::id();
        $mangaId = (int) $data['manga_id'];

        $existing = Bookmark::where('user_id', $userId)
            ->where('manga_id', $mangaId)
            ->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
        } else {
            Bookmark::create([
                'user_id' => $userId,
                'manga_id' => $mangaId,
            ]);
            $bookmarked = true;
        }

        $total = Bookmark::where('user_id', $userId)->count();

        return response()->json([
            'bookmarked' => $bookmarked,
            'count' => $total,
        ]);
    }

    /**
     * Sinkronisasi bookmark dari localStorage guest ke database user.
     */
    public function sync(Request $request)
    {
        $data = $request->validate([
            'bookmarks' => ['array'],
            'bookmarks.*.manga_id' => ['required', 'integer', 'exists:mangas,id'],
        ]);

        $userId = Auth::id();

        $mangaIds = collect($data['bookmarks'] ?? [])
            ->pluck('manga_id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if ($mangaIds->isNotEmpty()) {
            $existing = Bookmark::where('user_id', $userId)
                ->whereIn('manga_id', $mangaIds)
                ->pluck('manga_id');

            $toInsert = $mangaIds->diff($existing)
                ->map(fn ($mangaId) => [
                    'user_id' => $userId,
                    'manga_id' => $mangaId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            if ($toInsert->isNotEmpty()) {
                Bookmark::insert($toInsert->all());
            }
        }

        $syncedBookmarks = Bookmark::where('user_id', $userId)
            ->pluck('manga_id')
            ->values();

        return response()->json([
            'bookmarks' => $syncedBookmarks,
        ]);
    }
}