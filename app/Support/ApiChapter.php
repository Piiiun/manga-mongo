<?php

namespace App\Support;

/**
 * DTO untuk data chapter dari API Shinigami.
 *
 * Blade (home-manga-card) mengakses:
 * - $chapter->number        → digunakan di route('manga.read', [..., $chapter->number])
 * - $chapter->created_at    → digunakan dengan optional(...)->diffForHumans()
 *
 * Blade (manga-detail) juga mengakses:
 * - $chapter->title         → judul chapter (opsional)
 * - $chapter->views         → jumlah views
 * - $chapter->published_at  → ApiDate untuk tanggal rilis
 * - $chapter->created_at    → ApiDate (fallback untuk sorting)
 */
class ApiChapter
{
    public function __construct(
        public ?string $number,
        public ?string $slug,
        public ?ApiDate $created_at,
        public ?string $title = null,
        public ?int $views = 0,
        public ?ApiDate $published_at = null,
    ) {}

    /**
     * Buat ApiChapter dari data list API Shinigami.
     *
     * List endpoint hanya menyediakan latest_chapter (int) & latest_chapter_time (ISO).
     *
     * Contoh: {"latest_chapter": 29, "latest_chapter_time": "2026-08-08T17:31:52Z"}
     */
    public static function fromList(array $data): self
    {
        $number = isset($data['latest_chapter']) ? (string) $data['latest_chapter'] : null;
        $time = $data['latest_chapter_time'] ?? null;

        return new self(
            number: $number,
            slug: $data['latest_chapter_id'] ?? null,
            created_at: new ApiDate($time),
        );
    }

    /**
     * Buat ApiChapter dari data chapters endpoint API Shinigami.
     *
     * Contoh:
     * {"chapter_id": "7d84264b-...", "manga_id": "...", "chapter_number": 28,
     *  "chapter_title": null, "thumbnail": "https://...",
     *  "views": 18, "release_date": "2026-08-09T11:35:50Z"}
     */
    public static function fromDetail(array $data): self
    {
        $number = isset($data['chapter_number']) ? (string) $data['chapter_number'] : null;
        $releaseDate = $data['release_date'] ?? null;

        return new self(
            number: $number,
            slug: $data['chapter_id'] ?? null,
            created_at: new ApiDate($releaseDate),
            title: $data['chapter_title'] ?? null,
            views: isset($data['views']) ? (int) $data['views'] : 0,
            published_at: new ApiDate($releaseDate),
        );
    }
}
