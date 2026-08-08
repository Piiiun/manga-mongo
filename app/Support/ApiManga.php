<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * DTO untuk data manga dari API Shinigami.
 *
 * Mengubah struktur JSON API menjadi objek yang kompatibel
 * dengan Blade components (hero-slider, home-manga-card, popular-home).
 *
 * Properti yang diekspos:
 * - id, title, slug, cover_image, type, rating, views, description
 * - genres  (Collection)  → $manga->genres->take(n)
 * - chapters (Collection) → $manga->chapters->take(n) / ->count()
 *
 * Properti computed (via __get):
 * - formatted_views → $manga->formatted_views
 * - chapters_count  → $manga->chapters_count
 */
class ApiManga
{
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $slug = null,
        public ?string $cover_image = null,
        public ?string $type = null,
        public ?float $rating = null,
        public ?int $views = 0,
        public ?string $description = null,
        public ?Collection $genres = null,
        public ?Collection $chapters = null,
    ) {
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
     * Buat ApiManga dari data list API Shinigami (latest/popular).
     *
     * Contoh data API:
     * {"manga_id": "854d243b-...", "title": "...", "description": "...",
     *  "cover": "https://...", "cover_portrait": "https://...",
     *  "status": "Ongoing", "rating": 8.5, "views": 1917461,
     *  "format": "Manhwa", "latest_chapter": 29, "latest_chapter_time": "2026-08-08T17:31:52Z",
     *  "genres": [{"name": "Action", "slug": "action"}]}
     */
    public static function fromList(array $data): self
    {
        $genres = collect(array_map(
            fn ($g) => ApiGenre::fromApi($g),
            $data['genres'] ?? []
        ));

        $chapters = collect();
        if (isset($data['latest_chapter'])) {
            $chapters = collect([ApiChapter::fromList($data)]);
        }

        return new self(
            id: $data['manga_id'] ?? null,
            title: $data['title'] ?? null,
            slug: $data['manga_id'] ?? null,
            cover_image: $data['cover_portrait'] ?? $data['cover'] ?? null,
            type: $data['format'] ?? null,
            rating: isset($data['rating']) ? (float) $data['rating'] : null,
            views: $data['views'] ?? 0,
            description: $data['description'] ?? null,
            genres: $genres,
            chapters: $chapters,
        );
    }

    /**
     * Buat ApiManga dari data slider API Shinigami.
     *
     * Contoh data API:
     * {"id": 11, "title": "...", "rating": "9.4",
     *  "background_image": "https://...", "chara_image": "https://...",
     *  "manga_id": "935b0a6e-...", "description": "...",
     *  "badges": [{"name": "New", "color": "#F79F1F"}]}
     */
    public static function fromSlider(array $data): self
    {
        return new self(
            id: $data['manga_id'] ?? null,
            title: $data['title'] ?? null,
            slug: $data['manga_id'] ?? null,
            cover_image: $data['background_image'] ?? null,
            type: null,
            rating: isset($data['rating']) ? (float) $data['rating'] : null,
            views: 0,
            description: $data['description'] ?? null,
            genres: collect(),
            chapters: collect(),
        );
    }
}
