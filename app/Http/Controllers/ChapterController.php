<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Chapter;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MangaApiService;
use App\Support\ApiReadChapter;
use Illuminate\Support\Collection;

class ChapterController extends Controller
{
    public function read($manga_slug, $chapter_number)
    {
        // Try to find local Manga by slug first (DB-backed)
        $manga = Manga::where('slug', $manga_slug)->first();

        // Only use local DB chapters if the manga has chapters in DB.
        // Manga records created from bookmarking have no local chapters,
        // so we fall through to the API-backed path.
        if ($manga && Chapter::where('manga_id', $manga->id)->exists()) {
            // Local DB-backed chapter
            $chapter = Chapter::where('manga_id', $manga->id)
                ->where('number', $chapter_number)
                ->with([
                    'pages' => function ($query) {
                        $query->orderBy('page_number', 'asc');
                    },
                ])
                ->firstOrFail();

            // Load chapter comments by chapter_number (works for both local & API-backed)
            $comments = Comment::where('manga_id', $manga->id)
                ->forChapterNumber((int) $chapter_number)
                ->topLevel()
                ->with(['user', 'replies.user', 'replies.replies.user'])
                ->orderBy('created_at', 'desc')
                ->get();

            $chapterCommentsCount = Comment::where('manga_id', $manga->id)
                ->forChapterNumber((int) $chapter_number)
                ->count();

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
            $chapter->increment('views');

            if (Auth::check()) {
                Auth::user()->trackReading($manga->id, $chapter->number, 1, [
                    'api_manga_id' => $manga->slug,
                    'title' => $manga->title,
                    'cover_image' => $manga->cover_image,
                    'author' => $manga->author,
                    'status' => $manga->status,
                    'type' => $manga->type,
                    'rating' => $manga->rating,
                ]);
            }

            $chapterIsLocal = true;

            return view('read', compact(
                'manga',
                'chapter',
                'allChapters',
                'previousChapter',
                'nextChapter',
                'comments',
                'chapterCommentsCount',
                'chapterIsLocal'
            ));
        }

        // If local manga not found, try API-backed manga (manga_slug treated as manga_id)
        $service = new MangaApiService();
        $detail = $service->getDetail($manga_slug);
        if (empty($detail['data'])) {
            abort(404);
        }

        $mangaData = $detail['data'];

        // Use local Manga model if available (e.g. from bookmark), otherwise create one
        if ($manga) {
            $manga->description = $manga->description ?? ($mangaData['description'] ?? null);
        } else {
            $manga = Manga::updateOrCreate(
                ['slug' => $mangaData['manga_id'] ?? $manga_slug],
                [
                    'title' => $mangaData['title'] ?? 'Unknown',
                    'description' => $mangaData['description'] ?? null,
                    'cover_image' => $mangaData['cover_portrait'] ?? $mangaData['cover'] ?? null,
                    'status' => $mangaData['status'] ?? null,
                    'rating' => isset($mangaData['rating']) ? (float) $mangaData['rating'] : null,
                    'views' => $mangaData['views'] ?? 0,
                ]
            );
        }

        // Fetch all chapters via API and map to simple objects
        $allChaptersRaw = $service->getAllChapters($manga->slug);
        $allChapters = collect($allChaptersRaw ?: [])->map(function ($c) {
            return (object) [
                'id' => $c['chapter_id'] ?? ($c['id'] ?? null),
                'number' => (int) ($c['chapter_number'] ?? ($c['number'] ?? 0)),
                'title' => $c['chapter_title'] ?? null,
            ];
        })->sortByDesc('number')->values();

        // Find requested chapter by number
        $found = $allChapters->firstWhere('number', (int) $chapter_number);
        if (!$found) {
            abort(404);
        }

        // Call read endpoint using chapter id
        $readResp = $service->getRead($found->id);
        if (empty($readResp)) {
            abort(404);
        }

        $apiChapter = ApiReadChapter::fromResponse($readResp);

        // Build chapter object compatible with the view
        $chapter = (object) [
            'id' => $apiChapter->chapter_id,
            'number' => $apiChapter->number,
            'title' => $apiChapter->title,
            'published_at' => $apiChapter->published_at,
        ];

        // Pages collection for the view
        $chapterPages = $apiChapter->pages; // Collection of objects with image_path & page_number

        // Previous / Next chapters
        $previousChapter = $allChapters->filter(fn ($x) => $x->number < $apiChapter->number)->sortByDesc('number')->first();
        $nextChapter = $allChapters->filter(fn ($x) => $x->number > $apiChapter->number)->sortBy('number')->first();

        // Load chapter comments from DB by chapter_number
        $comments = Comment::where('manga_id', $manga->id)
            ->forChapterNumber((int) $chapter_number)
            ->topLevel()
            ->with(['user', 'replies.user', 'replies.replies.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $chapterCommentsCount = Comment::where('manga_id', $manga->id)
            ->forChapterNumber((int) $chapter_number)
            ->count();

        $chapterIsLocal = false;

        // Track reading history for API-backed manga
        if (Auth::check()) {
            $meta = [
                'api_manga_id' => $manga->slug,
                'title' => $manga->title,
                'cover_image' => $manga->cover_image ?? ($mangaData['cover_portrait'] ?? $mangaData['cover'] ?? null),
                'author' => $manga->author ?? null,
                'status' => $manga->status ?? ($mangaData['status'] ?? null),
                'type' => $manga->type ?? null,
                'rating' => $manga->rating ?? (isset($mangaData['rating']) ? (float) $mangaData['rating'] : null),
            ];

            Auth::user()->trackReading($manga->id, $apiChapter->number, 1, $meta);
        }

        return view('read', compact(
            'manga',
            'chapter',
            'allChapters',
            'previousChapter',
            'nextChapter',
            'chapterPages',
            'chapterCommentsCount',
            'comments',
            'chapterIsLocal'
        ));
    }
}