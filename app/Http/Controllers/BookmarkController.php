<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    // Halaman Bookmark
    public function index()
    {
        return view('bookmark');
    }
    
    // API untuk ambil data manga berdasarkan IDs dari localStorage
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
}