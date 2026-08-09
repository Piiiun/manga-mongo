<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Services\MangaApiService;
use App\Support\ApiMangaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingHistoryController extends Controller
{
    public function index()
    {
        $histories = Auth::user()
            ->readingHistories()
            ->with(['manga', 'manga.genres'])
            ->latest('last_read_at')
            ->paginate(20);

        return view('history.index', compact('histories'));
    }

    public function store(Request $request, MangaApiService $api)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'manga_id' => ['required'],
            'chapter_number' => ['required', 'integer'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $manga = $this->resolveManga($data['manga_id'], $api);

        if (!$manga) {
            return response()->json(['message' => 'Manga tidak ditemukan'], 404);
        }

        Auth::user()->trackReading(
            $manga->id,
            $data['chapter_number'],
            $data['page'] ?? 1,
            [
                'api_manga_id' => $manga->slug,
                'title' => $manga->title,
                'cover_image' => $manga->cover_image,
                'author' => $manga->author,
                'status' => $manga->status,
                'type' => $manga->type,
                'rating' => $manga->rating,
            ]
        );

        return response()->json(['message' => 'History saved']);
    }

    public function destroy($id)
    {
        $history = Auth::user()->readingHistories()->findOrFail($id);
        $history->delete();

        return back()->with('success', 'History berhasil dihapus!');
    }

    public function clear()
    {
        Auth::user()->readingHistories()->delete();

        return back()->with('success', 'Semua history berhasil dihapus!');
    }

    /**
     * Resolve identifier (numeric ID or API slug) ke Manga model.
     * Jika manga belum ada di DB, ambil dari API dan simpan.
     */
    protected function resolveManga(string $identifier, MangaApiService $api): ?Manga
    {
        if (is_numeric($identifier)) {
            $manga = Manga::find((int) $identifier);
            if ($manga) {
                return $manga;
            }
        }

        $manga = Manga::where('slug', $identifier)->first();
        if ($manga) {
            return $manga;
        }

        $detailResponse = $api->getDetail($identifier);
        if (!$detailResponse || !isset($detailResponse['data'])) {
            return null;
        }

        $apiManga = ApiMangaDetail::fromDetail($detailResponse['data'], []);

        return Manga::updateOrCreate(
            ['slug' => $apiManga->slug],
            [
                'title' => $apiManga->title,
                'alternative_title' => $apiManga->alternative_title,
                'description' => $apiManga->description,
                'cover_image' => $apiManga->cover_image,
                'author' => $apiManga->author,
                'artist' => $apiManga->artist,
                'status' => $apiManga->status,
                'type' => $apiManga->type,
                'rating' => $apiManga->rating,
                'released_at' => $apiManga->release_year,
                'views' => $apiManga->views,
            ]
        );
    }
}