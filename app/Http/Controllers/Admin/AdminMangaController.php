<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use App\Models\Genre;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminMangaController extends Controller
{
    // ============================================
    // MANGA MANAGEMENT
    // ============================================
    
    public function index()
    {
        $mangas = Manga::with('genres')
            ->withCount('chapters')
            ->latest()
            ->paginate(20);
        
        return view('admin.manga.index', compact('mangas'));
    }

    public function create()
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.manga.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'alternative_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'author' => 'nullable|string|max:255',
            'artist' => 'nullable|string|max:255',
            'status' => 'required|in:Ongoing,Completed',
            'type' => 'required|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:10',
            'released_at' => 'nullable|integer|min:1900|max:' . date('Y'),
            'serialization' => 'nullable|string|max:255',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $filename = Str::slug($request->title) . '-' . time() . '.' . $coverImage->extension();
            $path = $coverImage->storeAs('manga/covers', $filename, 'public');
            $validated['cover_image'] = $path;
        }

        // Auto-generate slug from title
        // Slug sudah di-handle oleh MangaObserver
        
        // Create manga
        $manga = Manga::create($validated);

        // Attach genres
        if ($request->has('genres')) {
            $manga->genres()->attach($request->genres);
        }

        return redirect()
            ->route('admin.manga.index')
            ->with('success', "Manga '{$manga->title}' berhasil ditambahkan!");
    }

    public function edit(Manga $manga)
    {
        $genres = Genre::orderBy('name')->get();
        $manga->load('genres');
        
        return view('admin.manga.edit', compact('manga', 'genres'));
    }

    public function update(Request $request, Manga $manga)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'alternative_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'author' => 'nullable|string|max:255',
            'artist' => 'nullable|string|max:255',
            'status' => 'required|in:Ongoing,Completed',
            'type' => 'required|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:10',
            'released_at' => 'nullable|integer|min:1900|max:' . date('Y'),
            'serialization' => 'nullable|string|max:255',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover
            if ($manga->cover_image) {
                Storage::disk('public')->delete($manga->cover_image);
            }

            $coverImage = $request->file('cover_image');
            $filename = Str::slug($request->title) . '-' . time() . '.' . $coverImage->extension();
            $path = $coverImage->storeAs('manga/covers', $filename, 'public');
            $validated['cover_image'] = $path;
        }

        // Update manga
        $manga->update($validated);

        // Sync genres
        if ($request->has('genres')) {
            $manga->genres()->sync($request->genres);
        } else {
            $manga->genres()->detach();
        }

        return redirect()
            ->route('admin.manga.index')
            ->with('success', "Manga '{$manga->title}' berhasil diupdate!");
    }

    public function destroy(Manga $manga)
    {
        // Delete cover image
        if ($manga->cover_image) {
            Storage::disk('public')->delete($manga->cover_image);
        }

        // Delete associated chapters and pages
        foreach ($manga->chapters as $chapter) {
            foreach ($chapter->pages as $page) {
                if ($page->image_path) {
                    Storage::disk('public')->delete($page->image_path);
                }
            }
            $chapter->pages()->delete();
        }
        $manga->chapters()->delete();

        // Delete manga
        $manga->delete();

        return redirect()
            ->route('admin.manga.index')
            ->with('success', "Manga berhasil dihapus!");
    }

    // ============================================
    // CHAPTER MANAGEMENT
    // ============================================

    public function chapters(Manga $manga)
    {
        $chapters = $manga->chapters()
            ->withCount('pages')
            ->orderBy('number', 'desc')
            ->paginate(50);
        
        return view('admin.manga.chapters', compact('manga', 'chapters'));
    }

    public function createChapter(Manga $manga)
    {
        return view('admin.manga.create-chapter', compact('manga'));
    }

    public function storeChapter(Request $request, Manga $manga)
    {
        $validated = $request->validate([
            'number' => 'required|numeric',
            'title' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        // Check if chapter already exists
        $existingChapter = $manga->chapters()
            ->where('number', $validated['number'])
            ->first();

        if ($existingChapter) {
            return back()
                ->withErrors(['number' => "Chapter {$validated['number']} sudah ada!"])
                ->withInput();
        }

        // Auto-generate slug
        $validated['slug'] = Str::slug("chapter-{$validated['number']}");
        $validated['manga_id'] = $manga->id;
        $validated['published_at'] = $validated['published_at'] ?? now();

        Chapter::create($validated);

        // Update manga's total chapters
        $manga->update([
            'total_chapters' => $manga->chapters()->count(),
            'last_update' => now(),
        ]);

        return redirect()
            ->route('admin.manga.chapters', $manga)
            ->with('success', "Chapter {$validated['number']} berhasil ditambahkan!");
    }

    public function editChapter(Manga $manga, Chapter $chapter)
    {
        return view('admin.manga.edit-chapter', compact('manga', 'chapter'));
    }

    public function updateChapter(Request $request, Manga $manga, Chapter $chapter)
    {
        $validated = $request->validate([
            'number' => 'required|numeric',
            'title' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        // Check if chapter number already exists (exclude current chapter)
        $existingChapter = $manga->chapters()
            ->where('number', $validated['number'])
            ->where('id', '!=', $chapter->id)
            ->first();

        if ($existingChapter) {
            return back()
                ->withErrors(['number' => "Chapter {$validated['number']} sudah ada!"])
                ->withInput();
        }

        // Auto-generate slug
        $validated['slug'] = Str::slug("chapter-{$validated['number']}");

        $chapter->update($validated);

        return redirect()
            ->route('admin.manga.chapters', $manga)
            ->with('success', "Chapter {$validated['number']} berhasil diupdate!");
    }

    public function destroyChapter(Manga $manga, Chapter $chapter)
    {
        // Delete all pages images
        foreach ($chapter->pages as $page) {
            if ($page->image_path) {
                Storage::disk('public')->delete($page->image_path);
            }
        }

        // Delete pages records
        $chapter->pages()->delete();

        // Delete chapter
        $chapter->delete();

        // Update manga's total chapters
        $manga->update([
            'total_chapters' => $manga->chapters()->count(),
            'last_update' => now(),
        ]);

        return redirect()
            ->route('admin.manga.chapters', $manga)
            ->with('success', "Chapter berhasil dihapus!");
    }
}