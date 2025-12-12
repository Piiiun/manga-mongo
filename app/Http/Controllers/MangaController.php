<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Manga;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function index(Request $request)
    {
        // Default sorting: A-Z
        $sort = $request->get('sort', 'a-z');
        $search = $request->get('search');
        $status = $request->get('status');
        $type = $request->get('type');
        $genres = Genre::orderBy('name')->get();
        $query = Manga::with('genres');

        // Search
        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        // Filter by type
        if ($type) {
            $query->where('type', $type);
        }

        // Filter berdasarkan genre
        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('slug', $request->genre);
            });
        }

        // Sorting
        switch ($sort) {
            case 'latest':
                $query->latest();
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'a-z':
            default:
                $query->orderBy('title', 'asc');
                break;
        }

        // Pagination dengan 12 item per halaman
        $mangas = $query->paginate(15);

        $mangas->appends($request->except('page'));
        $queryParams = array_filter($request->except('page'), function($value) {
            return !is_null($value) && $value !== '';
        });
        $queryString = $queryParams ? '&' . http_build_query($queryParams) : '';

        // Untuk view
        return view('manga', compact('mangas', 'genres', 'queryString'));
    }

    public function show($slug)
    {
        // Cari manga berdasarkan slug
        $manga = Manga::with(['genres', 'chapters.pages', 'bookmarks'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $manga->increment('views');

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