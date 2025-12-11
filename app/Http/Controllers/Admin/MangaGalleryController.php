<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use App\Models\MangaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MangaGalleryController extends Controller
{
    // Show upload form
    public function create(Manga $manga)
    {
        return view('admin.gallery.create', compact('manga'));
    }

    // Store gallery images
    public function store(Request $request, Manga $manga)
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB
            'titles' => 'nullable|array',
            'titles.*' => 'nullable|string|max:255',
            'descriptions' => 'nullable|array',
            'descriptions.*' => 'nullable|string|max:500',
            'type' => 'required|in:cover,artwork,promotional,fanart,other',
        ]);

        $uploaded = 0;
        $lastOrder = $manga->galleries()->max('order') ?? 0;

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('manga-gallery/' . $manga->slug, 'public');
            
            MangaGallery::create([
                'manga_id' => $manga->id,
                'uploaded_by' => auth()->id(),
                'image_path' => $path,
                'title' => $request->titles[$index] ?? null,
                'description' => $request->descriptions[$index] ?? null,
                'type' => $request->type,
                'order' => $lastOrder + $index + 1,
            ]);
            
            $uploaded++;
        }

        return back()->with('success', "$uploaded gambar berhasil diupload!");
    }

    // Update gallery item
    public function update(Request $request, MangaGallery $gallery)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
            'type' => 'required|in:cover,artwork,promotional,fanart,other',
        ]);

        $gallery->update($request->only(['title', 'description', 'order', 'type']));

        return back()->with('success', 'Gallery item berhasil diupdate!');
    }

    // Delete gallery item
    public function destroy(MangaGallery $gallery)
    {
        // Delete file
        Storage::disk('public')->delete($gallery->image_path);
        
        // Delete record
        $gallery->delete();

        return back()->with('success', 'Gallery item berhasil dihapus!');
    }

    // Reorder gallery
    public function reorder(Request $request, Manga $manga)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer|exists:manga_galleries,id',
        ]);

        foreach ($request->orders as $order => $galleryId) {
            MangaGallery::where('id', $galleryId)
                ->where('manga_id', $manga->id)
                ->update(['order' => $order]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }
}