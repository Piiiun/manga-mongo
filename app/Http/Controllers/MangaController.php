<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Services\MangaApiService;
use App\Support\ApiManga;
use App\Support\ApiMangaDetail;
use App\Support\ApiPaginator;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function __construct(
        protected MangaApiService $api,
    ) {}

    public function index(Request $request)
    {
        $page = (int) $request->get('page', 1);
        $search = $request->get('search');
        $sort = $request->get('sort', 'latest');
        $status = $request->get('status');
        $type = $request->get('type');
        $genre = $request->get('genre');

        // Map sort Blade → API
        $sortMap = [
            'a-z' => 'title',
            'latest' => 'latest',
            'popular' => 'popular',
            'rating' => 'rating',
        ];
        $apiSort = $sortMap[$sort] ?? 'latest';

        // Ambil daftar genre untuk dropdown filter
        $genresResponse = $this->api->getGenres() ?? [];
        $genres = collect($genresResponse['data'] ?? [])
            ->map(fn ($g) => (object) $g);

        // --- Search: endpoint terpisah ---
        if ($search) {
            $response = $this->api->search($search, $page) ?? [];
            $mangas = ApiPaginator::fromResponse($response, fn ($item) => ApiManga::fromList($item));
        }
        // --- Advanced filter: ada genre/status/type ---
        elseif ($genre || $status || $type || in_array($apiSort, ['popular', 'rating', 'title'])) {
            $params = [
                'sort' => $apiSort,
                'page' => $page,
            ];
            if ($genre) {
                $params['genre_include'] = $genre;
            }
            if ($status) {
                $params['status'] = $status;
            }
            if ($type) {
                $params['format'] = ucfirst($type);
            }

            $response = $this->api->advancedSearch($params) ?? [];
            $mangas = ApiPaginator::fromResponse($response, fn ($item) => ApiManga::fromList($item));
        }
        // --- Default: latest manga ---
        else {
            $response = $this->api->getLatest($page) ?? [];
            $mangas = ApiPaginator::fromResponse($response, fn ($item) => ApiManga::fromList($item));
        }

        // Preserve query params on pagination links
        $mangas->appends($request->except('page'));

        return view('manga', compact('mangas', 'genres'));
    }

    public function show($slug)
    {
        // Ambil detail manga dari API Shinigami
        $detailResponse = $this->api->getDetail($slug);

        if (!$detailResponse || !isset($detailResponse['data'])) {
            abort(404, 'Manga tidak ditemukan');
        }

        // Ambil semua chapter dari API (mendukung pagination)
        $chapters = $this->api->getAllChapters($slug);

        // Buat DTO ApiMangaDetail dari response API
        $manga = ApiMangaDetail::fromDetail($detailResponse['data'], $chapters);

        // Return view detail
        return view('manga-detail', compact('manga'));
    }

    public function detail($slug)
    {
        $manga = Manga::where('slug', $slug)
            ->with([
                'genres',
                'chapters' => function($q) {
                    $q->orderBy('number', 'desc');
                },
                'galleries' => function($q) {
                    $q->ordered();
                },
                'ratings' => function($q) {
                    $q->with('user')->latest()->take(20);
                },
                'comments' => function($q) {
                    $q->topLevel()
                    ->with(['user', 'replies.user'])
                    ->orderBy('created_at', 'desc');
                }
            ])
            ->withCount(['rating'])
            ->firstOrFail();

        // Increment views
        $manga->increment('views');

        return view('manga.detail', compact('manga',));
    }

}