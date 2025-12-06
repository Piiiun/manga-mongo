<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function read($manga_slug, $chapter_number)
    {
        // Cari manga berdasarkan slug
        $manga = Manga::where('slug', $manga_slug)->firstOrFail();

        // Cari chapter berdasarkan number
        $chapter = Chapter::where('manga_id', $manga->id)
            ->where('number', $chapter_number)
            ->with(['pages' => function($query) {
                $query->orderBy('page_number', 'asc');
            }])
            ->firstOrFail();

        // Get all chapters untuk dropdown
        $allChapters = Chapter::where('manga_id', $manga->id)
            ->orderBy('number', 'desc')
            ->get();

        // Get previous and next chapter
        $previousChapter = Chapter::where('manga_id', $manga->id)
            ->where('number', '<', $chapter->number)
            ->orderBy('number', 'desc')
            ->first();

        $nextChapter = Chapter::where('manga_id', $manga->id)
            ->where('number', '>', $chapter->number)
            ->orderBy('number', 'asc')
            ->first();

        // Increment chapter views (optional)
        // $chapter->increment('views');

        return view('read', compact(
            'manga',
            'chapter',
            'allChapters',
            'previousChapter',
            'nextChapter'
        ));
    }
}