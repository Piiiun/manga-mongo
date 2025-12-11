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
    public function storeManga(Request $request, Manga $manga)
    {
        $request->validate([
            'content' => 'required|string|max:1000',    
            'is_spoiler' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = $manga->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_spoiler' => $request->boolean('is_spoiler'),
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // Store chapter comment
    public function storeChapter(Request $request, Manga $manga, Chapter $chapter)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'is_spoiler' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'manga_id' => $manga->id,
            'chapter_id' => $chapter->id,
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
}