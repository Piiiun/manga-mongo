<?php

namespace App\Observers;

use App\Models\Manga;
use Illuminate\Support\Str;

class MangaObserver
{
    /**
     * Handle the Manga "creating" event.
     * Generate slug dari title sebelum disimpan
     */
    public function creating(Manga $manga): void
    {
        if (empty($manga->slug)) {
            $manga->slug = $this->generateUniqueSlug($manga->title);
        }
    }

    /**
     * Handle the Manga "updating" event.
     * Update slug jika title berubah
     */
    public function updating(Manga $manga): void
    {
        // Jika title berubah, generate slug baru
        if ($manga->isDirty('title')) {
            $manga->slug = $this->generateUniqueSlug($manga->title, $manga->id);
        }
    }

    /**
     * Generate unique slug dari title
     */
    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // Cek apakah slug sudah ada
        while ($this->slugExists($slug, $ignoreId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Cek apakah slug sudah ada di database
     */
    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $query = Manga::where('slug', $slug);
        
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }
        
        return $query->exists();
    }
}