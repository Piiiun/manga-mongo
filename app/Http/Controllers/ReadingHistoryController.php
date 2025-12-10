<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'manga_id' => 'required|exists:mangas,id',
            'chapter_number' => 'required|integer',
            'page' => 'nullable|integer|min:1',
        ]);

        Auth::user()->trackReading(
            $request->manga_id,
            $request->chapter_number,
            $request->page ?? 1
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
}