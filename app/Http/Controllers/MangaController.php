<?php

namespace App\Http\Controllers;

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
        $mangas = $query->paginate(12);

        $queryParams = $request->except('page');
        $queryString = $queryParams ? '&' . http_build_query($queryParams) : '';

        // Tambahkan query parameters ke pagination links
        $mangas->appends([
            'sort' => $sort,
            'search' => $search,
            'status' => $status,
            'type' => $type,
        ]);

        // Untuk view
        return view('manga', compact('mangas'));
    }

    public function show($id)
    {
        $manga = Manga::with('genres', 'chapters')->findOrFail($id);
        return view('manga', compact('manga'));
    }
}