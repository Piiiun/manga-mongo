<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * DTO untuk data detail manga dari API Shinigami.
 *
 * Mengubah struktur JSON dari endpoint /detail/{manga_id} menjadi
 * objek yang kompatibel dengan Blade view manga-detail.
 *
 * Properti yang diekspos:
 * - id, title, slug, cover_image, type, status, rating, views
 * - description, alternative_title, release_year, country
 * - authors (Collection), artists (Collection)
 * - genres (Collection), chapters (Collection)
 * - bookmarks_count, is_recommended, rank
 * - created_at (ApiDate), updated_at (ApiDate), last_update (ApiDate)
 *
 * Properti computed (via __get):
 * - formatted_views → $manga->formatted_views
 * - author          → string gabungan nama authors
 * - artist          → string gabungan nama artists
 * - released_at     → release_year
 * - serialization   → null (API tidak menyediakan)
 * - average_rating  → rating (API sudah memberikan rating agregat)
 * - total_ratings   → 0 (API tidak menyediakan breakdown)
 */
class ApiMangaDetail
{
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $slug = null,
        public ?string $cover_image = null,
        public ?string $type = null,
        public ?string $status = null,
        public ?float $rating = null,
        public ?int $views = 0,
        public ?string $description = null,
        public ?string $alternative_title = null,
        public ?string $release_year = null,
        public ?string $country = null,
        public ?Collection $authors = null,
        public ?Collection $artists = null,
        public ?Collection $genres = null,
        public ?Collection $chapters = null,
        public ?int $bookmarks_count = 0,
        public bool $is_recommended = false,
        public ?int $rank = null,
        public ?ApiDate $created_at = null,
        public ?ApiDate $updated_at = null,
        public ?ApiDate $last_update = null,
    ) {
        $this->authors ??= collect();
        $this->artists ??= collect();
        $this->genres ??= collect();
        $this->chapters ??= collect();
    }

    /**
     * Akses properti computed yang tidak dideklarasikan.
     */
    public function __get(string $name)
    {
        return match ($name) {
            'formatted_views' => $this->getFormattedViews(),
            'author'          => $this->authors->pluck('name')->implode(', ') ?: null,
            'artist'          => $this->artists->pluck('name')->implode(', ') ?: null,
            'released_at'     => $this->release_year,
            'serialization'   => null,
            'average_rating'  => $this->rating,
            'total_ratings'   => 0,
            'chapters_count'  => $this->chapters->count(),
            default           => null,
        };
    }

    /**
     * Format views seperti accessor di Manga model.
     */
    protected function getFormattedViews(): string
    {
        $views = $this->views ?? 0;

        if ($views >= 1000000000) {
            return number_format($views / 1000000000, 1) . 'B';
        }
        if ($views >= 1000000) {
            return number_format($views / 1000000, 1) . 'M';
        }
        if ($views >= 1000) {
            return number_format($views / 1000, 1) . 'K';
        }

        return number_format($views);
    }

    /**
     * Buat ApiMangaDetail dari response endpoint /detail/{manga_id}.
     *
     * Contoh data API:
     * {"id": 1359, "manga_id": "c95e6025-...", "title": "...",
     *  "alternative_title": "...", "description": "...",
     *  "cover": "https://...", "cover_portrait": null,
     *  "status": "Ongoing", "release_year": "2026", "country": "KR",
     *  "rating": 7, "views": 67979, "bookmarks": 965, "rank": 9999,
     *  "is_recommended": false,
     *  "latest_chapter": {"chapter_id": "...", "chapter_number": 28, "updated_at": "..."},
     *  "genres": [{"id": 27, "name": "Fantasy", "slug": "fantasy"}],
     *  "authors": [{"id": 2717, "name": "Bambi", "slug": "bambi-author"}],
     *  "artists": [{"id": 2719, "name": "Begae", "slug": "begae-artist"}],
     *  "format": [{"id": 10, "name": "Manhwa", "slug": "manhwa"}],
     *  "type": [{"id": 13, "name": "Mirror", "slug": "mirror"}],
     *  "created_at": "2026-06-23T10:20:49Z", "updated_at": "2026-08-09T11:54:21Z"}
     *
     * @param array $data  Data dari key "data" response API
     * @param array $chapters  (Optional) Array chapter dari endpoint /chapters/{manga_id}
     */
    public static function fromDetail(array $data, array $chapters = []): self
    {
        $genres = collect(array_map(
            fn ($g) => ApiGenre::fromApi($g),
            $data['genres'] ?? []
        ));

        $authors = collect($data['authors'] ?? [])->map(fn ($a) => (object) $a);
        $artists = collect($data['artists'] ?? [])->map(fn ($a) => (object) $a);

        // Format: array of objects → ambil nama pertama
        $format = collect($data['format'] ?? [])->map(fn ($f) => (object) $f);
        $type = collect($data['type'] ?? [])->map(fn ($t) => (object) $t);

        $coverImage = $data['cover_portrait'] ?? $data['cover'] ?? null;

        // Map chapters dari endpoint chapters, urutkan descending by number
        $chapterCollection = collect(array_map(
            fn ($c) => ApiChapter::fromDetail($c),
            $chapters
        ))->sortByDesc(fn ($c) => (float) $c->number)->values();

        // last_update dari latest_chapter.updated_at atau updated_at manga
        $latestChapterTime = $data['latest_chapter']['updated_at'] ?? null;
        $updatedAt = $data['updated_at'] ?? null;

        return new self(
            id: $data['manga_id'] ?? null,
            title: $data['title'] ?? null,
            slug: $data['manga_id'] ?? null,
            cover_image: $coverImage,
            type: $format->first()?->name ?? $type->first()?->name ?? null,
            status: $data['status'] ?? null,
            rating: isset($data['rating']) ? (float) $data['rating'] : null,
            views: $data['views'] ?? 0,
            description: $data['description'] ?? null,
            alternative_title: $data['alternative_title'] ?? null,
            release_year: $data['release_year'] ?? null,
            country: $data['country'] ?? null,
            authors: $authors,
            artists: $artists,
            genres: $genres,
            chapters: $chapterCollection,
            bookmarks_count: $data['bookmarks'] ?? 0,
            is_recommended: $data['is_recommended'] ?? false,
            rank: isset($data['rank']) ? (int) $data['rank'] : null,
            created_at: new ApiDate($data['created_at'] ?? null),
            updated_at: new ApiDate($updatedAt),
            last_update: new ApiDate($latestChapterTime ?? $updatedAt),
        );
    }
}
