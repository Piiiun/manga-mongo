<?php

namespace App\Support;

/**
 * DTO untuk data genre dari API Shinigami.
 *
 * Blade mengakses:
 * - $genre->name → untuk menampilkan nama genre
 * - $genre->slug → untuk route('manga.list', ['genre' => $genre->slug])
 *
 * API Shinigami sudah mengembalikan slug dalam format bersih ("action").
 */
class ApiGenre
{
    public function __construct(
        public ?string $name,
        public ?string $slug,
    ) {}

    /**
     * Buat ApiGenre dari data API Shinigami.
     *
     * Contoh data API:
     * {"name": "Action", "slug": "action"}
     */
    public static function fromApi(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            slug: $data['slug'] ?? null,
        );
    }
}
