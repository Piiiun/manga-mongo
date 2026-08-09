<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Bookmark;
use App\Services\MangaApiService;
use App\Support\ApiMangaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
     * API untuk ambil data manga berdasarkan IDs dari localStorage (mode guest)
     * atau daftar bookmark dari database untuk user login.
     */
    public function getMangas(Request $request)
    {
        if (Auth::check()) {
            $bookmarks = Bookmark::where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->get();

            $mangas = $bookmarks->map(fn ($bookmark) => $this->serializeBookmark($bookmark));
            return response()->json(['mangas' => $mangas->values()]);
        }

        $ids = collect($request->input('ids', []))->filter()->values();
        if ($ids->isEmpty()) {
            return response()->json(['mangas' => []]);
        }

        $numericIds = $ids->filter(fn ($id) => is_numeric($id))->map(fn ($id) => (int) $id)->unique()->values();
        $stringIds = $ids->filter(fn ($id) => !is_numeric($id))->unique()->values();

        $mangas = Manga::query()
            ->when($numericIds->isNotEmpty(), fn ($query) => $query->orWhereIn('id', $numericIds))
            ->when($stringIds->isNotEmpty(), fn ($query) => $query->orWhereIn('slug', $stringIds))
            ->select('id', 'title', 'slug', 'cover_image', 'author', 'rating', 'status', 'description')
            ->get()
            ->map(fn ($manga) => $this->serializeManga($manga));

        return response()->json(['mangas' => $mangas]);
    }

    /**
     * Ambil daftar bookmark milik user yang sedang login.
     */
    public function index()
    {
        $userId = Auth::id();

        $bookmarks = Bookmark::where('user_id', $userId)
            ->get()
            ->map(fn ($bookmark) => (string) ($bookmark->api_manga_id ?? $bookmark->manga_id));

        return response()->json([
            'bookmarks' => $bookmarks->values(),
        ]);
    }

    /**
     * Tambah / hapus bookmark untuk user login.
     */
    public function toggle(Request $request, MangaApiService $api)
    {
        $data = $request->validate([
            'manga_id' => ['required'],
        ]);

        $userId = Auth::id();
        $manga = $this->resolveManga($data['manga_id'], $api);

        if (!$manga) {
            return response()->json(['message' => 'Manga tidak ditemukan'], 404);
        }

        $existing = Bookmark::where('user_id', $userId)
            ->where('manga_id', $manga->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
        } else {
            Bookmark::create($this->getBookmarkPayload($userId, $manga));
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
    public function sync(Request $request, MangaApiService $api)
    {
        $data = $request->validate([
            'bookmarks' => ['array'],
            'bookmarks.*.manga_id' => ['required'],
        ]);

        $userId = Auth::id();
        $identifiers = collect($data['bookmarks'] ?? [])
            ->pluck('manga_id')
            ->filter()
            ->unique()
            ->values();

        $resolvedMangas = collect();

        foreach ($identifiers as $identifier) {
            $manga = $this->resolveManga($identifier, $api);
            if ($manga) {
                $resolvedMangas->push($manga);
            }
        }

        $resolvedIds = $resolvedMangas->pluck('id')->unique()->values();

        if ($resolvedIds->isNotEmpty()) {
            $existing = Bookmark::where('user_id', $userId)
                ->whereIn('manga_id', $resolvedIds)
                ->pluck('manga_id');

            $toInsert = $resolvedMangas
                ->filter(fn ($manga) => !$existing->contains($manga->id))
                ->map(fn ($manga) => array_merge(
                    $this->getBookmarkPayload($userId, $manga),
                    ['source' => 'local', 'created_at' => now(), 'updated_at' => now()]
                ));

            if ($toInsert->isNotEmpty()) {
                Bookmark::insert($toInsert->all());
            }
        }

        $syncedBookmarks = Bookmark::where('user_id', $userId)
            ->get()
            ->map(fn ($bookmark) => (string) ($bookmark->api_manga_id ?? $bookmark->manga_id))
            ->values();

        return response()->json([
            'bookmarks' => $syncedBookmarks,
        ]);
    }

    /**
     * Resolve identifier (numeric ID or API slug) ke Manga model.
     * Jika manga belum ada di DB, ambil dari API dan simpan.
     */
    protected function resolveManga(string $identifier, MangaApiService $api): ?Manga
    {
        // Coba cari berdasarkan ID numerik
        if (is_numeric($identifier)) {
            $manga = Manga::find((int) $identifier);
            if ($manga) {
                return $manga;
            }
        }

        // Coba cari berdasarkan slug (api_manga_id)
        $manga = Manga::where('slug', $identifier)->first();
        if ($manga) {
            return $manga;
        }

        // Ambil dari API dan simpan ke DB
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

    /**
     * Payload untuk membuat bookmark baru dengan metadata dari API.
     */
    protected function getBookmarkPayload(int $userId, Manga $manga): array
    {
        return [
            'user_id' => $userId,
            'manga_id' => $manga->id,
            'api_manga_id' => $manga->slug,
            'slug' => $manga->slug,
            'title' => $manga->title,
            'cover_image' => $manga->cover_image,
            'author' => $manga->author,
            'status' => $manga->status,
            'type' => $manga->type,
            'rating' => $manga->rating,
            'description' => $manga->description,
            'source' => 'api',
        ];
    }

    /**
     * Serialize bookmark untuk response JSON (data dari DB, bukan API).
     */
    protected function serializeBookmark(Bookmark $bookmark): array
    {
        $coverImage = $bookmark->cover_image ?: $bookmark->manga?->cover_image;
        if ($coverImage && !Str::startsWith($coverImage, ['http://', 'https://'])) {
            $coverImage = asset('storage/manga/' . $coverImage);
        }

        return [
            'id' => (string) ($bookmark->api_manga_id ?? $bookmark->manga_id),
            'slug' => $bookmark->slug ?? $bookmark->manga?->slug,
            'title' => $bookmark->title ?? $bookmark->manga?->title,
            'cover_image' => $coverImage ?: asset('images/no-cover.jpg'),
            'author' => $bookmark->author ?? $bookmark->manga?->author,
            'rating' => $bookmark->rating ?? $bookmark->manga?->rating,
            'status' => $bookmark->status ?? $bookmark->manga?->status,
            'type' => $bookmark->type ?? $bookmark->manga?->type,
            'description' => $bookmark->description ?? $bookmark->manga?->description,
        ];
    }

    /**
     * Serialize manga model untuk response JSON (mode guest).
     */
    protected function serializeManga(Manga $manga): array
    {
        $coverImage = $manga->cover_image;
        if ($coverImage && !Str::startsWith($coverImage, ['http://', 'https://'])) {
            $coverImage = asset('storage/manga/' . $coverImage);
        }

        return [
            'id' => (string) $manga->slug,
            'slug' => $manga->slug,
            'title' => $manga->title,
            'cover_image' => $coverImage ?: asset('images/no-cover.jpg'),
            'author' => $manga->author,
            'rating' => $manga->rating,
            'status' => $manga->status,
            'type' => $manga->type,
            'description' => $manga->description,
        ];
    }
}