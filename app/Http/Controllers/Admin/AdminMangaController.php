<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\Genre;
use App\Models\Manga;
use App\Models\Chapter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
            $slug = Str::slug($request->title);
            $filename = $slug . '.' . $coverImage->extension();
            
            // Save to manga/covers/
            $coverImage->storeAs('manga/covers', $filename, 'public');
            $validated['cover_image'] = 'covers/' . $filename;
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
            // Delete old cover if exists
            if ($manga->cover_image && Storage::disk('public')->exists($manga->cover_image)) {
                Storage::disk('public')->delete($manga->cover_image);
            }

            $coverImage = $request->file('cover_image');
            $slug = Str::slug($request->title);
            $filename = $slug . '.' . $coverImage->extension();
            
            // Ensure directory exists
            Storage::disk('public')->makeDirectory('manga/covers');
            
            // Save to manga/covers/
            $path = $coverImage->storeAs('public/covers', $filename, 'public');
            
            if ($path) {
                $validated['cover_image'] = 'covers/' . $filename;
            } else {
                return back()->with('error', 'Gagal upload cover image!');
            }
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

    // ============================================
    // SYNC IMAGES FROM FOLDER
    // ============================================

    public function syncChapterImages(Manga $manga, Chapter $chapter)
    {
        try {
            // Define chapter folder path
            $chapterFolderPath = "manga/pages/{$manga->slug}/chapter-{$chapter->number}";
            $fullPath = storage_path("app/public/{$chapterFolderPath}");

            // Check if folder exists
            if (!file_exists($fullPath)) {
                return back()->with('error', "Folder tidak ditemukan: {$chapterFolderPath}");
            }

            // Get all image files
            $imageFiles = glob($fullPath . "/page-*.{jpg,jpeg,png,webp}", GLOB_BRACE);
            
            if (empty($imageFiles)) {
                return back()->with('error', "Tidak ada gambar ditemukan di folder: {$chapterFolderPath}");
            }

            // Sort files by page number
            usort($imageFiles, function($a, $b) {
                preg_match('/page-(\d+)/', basename($a), $matchA);
                preg_match('/page-(\d+)/', basename($b), $matchB);
                return (int)($matchA[1] ?? 0) - (int)($matchB[1] ?? 0);
            });

            // Delete existing pages
            $chapter->pages()->delete();

            // Insert new pages
            $insertedPages = 0;
            foreach ($imageFiles as $index => $imageFile) {
                $filename = basename($imageFile);
                $imagePath = "{$chapterFolderPath}/{$filename}";

                // Extract page number from filename
                preg_match('/page-(\d+)/', $filename, $match);
                $pageNumber = $match[1] ?? ($index + 1);

                Page::create([
                    'chapter_id' => $chapter->id,
                    'page_number' => $pageNumber,
                    'image_path' => $imagePath,
                ]);

                $insertedPages++;
            }

            // Update manga's last_update
            $manga->update(['last_update' => now()]);

            return back()->with('success', "Berhasil sync {$insertedPages} halaman untuk Chapter {$chapter->number}!");

        } catch (\Exception $e) {
            return back()->with('error', "Error: " . $e->getMessage());
        }
    }

    public function syncAllChapters(Manga $manga)
    {
        try {
            $totalSynced = 0;
            $errors = [];

            $chapters = $manga->chapters()->get();

            foreach ($chapters as $chapter) {
                // Define chapter folder path
                $chapterFolderPath = "manga/pages/{$manga->slug}/chapter-{$chapter->number}";
                $fullPath = storage_path("app/public/{$chapterFolderPath}");

                // Skip if folder doesn't exist
                if (!file_exists($fullPath)) {
                    $errors[] = "Chapter {$chapter->number}: Folder tidak ditemukan";
                    continue;
                }

                // Get all image files
                $imageFiles = glob($fullPath . "/page-*.{jpg,jpeg,png,webp}", GLOB_BRACE);
                
                if (empty($imageFiles)) {
                    $errors[] = "Chapter {$chapter->number}: Tidak ada gambar";
                    continue;
                }

                // Sort files
                usort($imageFiles, function($a, $b) {
                    preg_match('/page-(\d+)/', basename($a), $matchA);
                    preg_match('/page-(\d+)/', basename($b), $matchB);
                    return (int)($matchA[1] ?? 0) - (int)($matchB[1] ?? 0);
                });

                // Delete existing pages
                $chapter->pages()->delete();

                // Insert new pages
                foreach ($imageFiles as $index => $imageFile) {
                    $filename = basename($imageFile);
                    $imagePath = "{$chapterFolderPath}/{$filename}";

                    preg_match('/page-(\d+)/', $filename, $match);
                    $pageNumber = $match[1] ?? ($index + 1);

                    Page::create([
                        'chapter_id' => $chapter->id,
                        'page_number' => $pageNumber,
                        'image_path' => $imagePath,
                    ]);
                }

                $totalSynced++;
            }

            // Update manga's last_update
            $manga->update(['last_update' => now()]);

            $message = "Berhasil sync {$totalSynced} chapter!";
            if (!empty($errors)) {
                $message .= " Errors: " . implode(', ', $errors);
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', "Error: " . $e->getMessage());
        }
    }
}