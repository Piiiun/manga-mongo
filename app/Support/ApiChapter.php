<?php

namespace App\Support;

/**
 * DTO untuk data chapter dari API Shinigami.
 *
 * Blade (home-manga-card) mengakses:
 * - $chapter->number        → digunakan di route('manga.read', [..., $chapter->number])
 * - $chapter->created_at    → digunakan dengan optional(...)->diffForHumans()
 */
class ApiChapter
{
    public function __construct(
        public ?string $number,
        public ?string $slug,
        public ?ApiDate $created_at,
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
}
