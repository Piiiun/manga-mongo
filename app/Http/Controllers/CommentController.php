<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Manga;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Store manga comment
    public function storeManga(Request $request, $manga)
    {
        $mangaModel = $this->resolveManga($manga);

        if (!$mangaModel) {
            return back()->with('error', 'Manga tidak ditemukan!');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'is_spoiler' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $mangaModel->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_spoiler' => $request->boolean('is_spoiler'),
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // Store chapter comment
    public function storeChapter(Request $request, $manga, $chapter = null)
    {
        $mangaModel = $this->resolveManga($manga);

        if (!$mangaModel) {
            return back()->with('error', 'Manga tidak ditemukan!');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'is_spoiler' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:comments,id',
            'chapter_number' => 'nullable|integer',
        ]);

        $chapterNumber = $request->integer('chapter_number');
        $chapterId = null;

        // Try to find local chapter
        if ($chapter) {
            $chapterModel = $chapter instanceof Chapter
                ? $chapter
                : Chapter::where('manga_id', $mangaModel->id)
                    ->where('id', $chapter)
                    ->orWhere('number', $chapter)
                    ->first();
            $chapterId = $chapterModel?->id;
            $chapterNumber = $chapterNumber ?: $chapterModel?->number;
        }

        Comment::create([
            'user_id' => Auth::id(),
            'manga_id' => $mangaModel->id,
            'chapter_id' => $chapterId,
            'chapter_number' => $chapterNumber,
            'content' => $request->content,
            'is_spoiler' => $request->boolean('is_spoiler'),
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // Update comment
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki akses!');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'is_spoiler' => 'nullable|boolean',
        ]);

        $comment->update([
            'content' => $request->content,
            'is_spoiler' => $request->boolean('is_spoiler'),
        ]);

        return back()->with('success', 'Komentar berhasil diupdate!');
    }

    // Delete comment
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki akses!');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }

    // Like/Unlike comment
    public function toggleLike(Comment $comment)
    {
        $user = Auth::user();

        if ($comment->isLikedBy($user)) {
            $comment->likedByUsers()->detach($user->id);
            $comment->decrement('likes');
            $liked = false;
        } else {
            $comment->likedByUsers()->attach($user->id);
            $comment->increment('likes');
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes' => $comment->likes,
        ]);
    }

    /**
     * Resolve manga from slug string or Manga model.
     */
    protected function resolveManga($manga): ?Manga
    {
        if ($manga instanceof Manga) {
            return $manga;
        }

        return Manga::where('slug', $manga)->first();
    }
}