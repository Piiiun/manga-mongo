<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class ApiReadChapter
{
    public string $chapter_id;
    public int $number;
    public ?string $title = null;
    public ?Carbon $published_at = null;
    /** @var Collection<int, object> */
    public Collection $pages;
    public array $raw = [];

    public static function fromResponse(array $response): self
    {
        $data = $response['data'] ?? $response;

        $instance = new self();
        $instance->raw = $data;
        $instance->chapter_id = $data['chapter_id'] ?? ($data['id'] ?? '');
        $instance->number = isset($data['chapter_number']) ? (int) $data['chapter_number'] : (int) ($data['number'] ?? 0);
        $instance->title = $data['chapter_title'] ?? ($data['title'] ?? null);

        if (!empty($data['release_date'])) {
            $instance->published_at = Carbon::parse($data['release_date']);
        } elseif (!empty($data['published_at'])) {
            $instance->published_at = Carbon::parse($data['published_at']);
        }

        $pages = [];

        // Try common shapes: data.pages => array of {page_number, url} or strings
        if (!empty($data['pages']) && is_array($data['pages'])) {
            foreach ($data['pages'] as $i => $p) {
                if (is_array($p)) {
                    $img = $p['image'] ?? $p['url'] ?? $p['src'] ?? ($p['path'] ?? null);
                } else {
                    $img = $p;
                }
                $pages[] = (object) [
                    'page_number' => $p['page_number'] ?? ($i + 1),
                    'image_path' => $img,
                ];
            }
        }

        // fallback: data.images is array of urls
        if (empty($pages) && !empty($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $i => $img) {
                $pages[] = (object) [
                    'page_number' => $i + 1,
                    'image_path' => $img,
                ];
            }
        }

        // fallback: data is array of urls
        if (empty($pages) && is_array($data) && array_values($data) === $data) {
            // numeric indexed array maybe pages
            foreach ($data as $i => $item) {
                if (is_string($item) && str_starts_with($item, 'http')) {
                    $pages[] = (object) [
                        'page_number' => $i + 1,
                        'image_path' => $item,
                    ];
                }
            }
        }

        $instance->pages = collect($pages);

        return $instance;
    }
}
