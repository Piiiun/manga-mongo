<?php

namespace App\Support;

use Carbon\Carbon;

/**
 * Wrapper untuk tanggal dari API Shinigami.
 *
 * API Shinigami mengembalikan timestamp ISO 8601 (mis. "2026-08-08T17:31:52Z").
 * Blade memanggil optional($chapter->created_at)->diffForHumans(),
 * sehingga kelas ini menyediakan method diffForHumans() yang
 * menggunakan Carbon untuk menghasilkan relative time.
 */
class ApiDate
{
    protected ?Carbon $carbon;

    public function __construct(?string $date)
    {
        $this->carbon = $date ? Carbon::parse($date) : null;
    }

    public function diffForHumans(): ?string
    {
        return $this->carbon?->diffForHumans();
    }

    public function __toString(): string
    {
        return (string) $this->carbon ?? '';
    }
}
