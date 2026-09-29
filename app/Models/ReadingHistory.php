<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingHistory extends Model
{
    /** Maximum number of history entries per user. */
    const MAX_PER_USER = 50;

    protected $fillable = [
        'user_id',
        'manga_id',
        'api_manga_id',
        'title',
        'cover_image',
        'author',
        'status',
        'type',
        'rating',
        'chapter_number',
        'last_page',
        'last_read_at',
    ];

    protected $casts = [
        'last_read_at' => 'datetime',
    ];

    // Relationship ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship ke Manga
    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }

    // Relationship ke Chapter
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_number', 'number')
                    ->where('manga_id', $this->manga_id);
    }

    // Scope untuk mendapatkan history terbaru
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('last_read_at', 'desc')->limit($limit);
    }

    /**
     * Resolve title from local metadata or related Manga.
     */
    public function getResolvedTitleAttribute(): ?string
    {
        return $this->title ?? $this->manga?->title;
    }

    /**
     * Resolve slug (api_manga_id) from local metadata or related Manga.
     */
    public function getResolvedSlugAttribute(): ?string
    {
        return $this->api_manga_id ?? $this->manga?->slug;
    }

    /**
     * Resolve cover image URL from local metadata or related Manga.
     */
    public function getResolvedCoverImageAttribute(): ?string
    {
        $cover = $this->cover_image ?? $this->manga?->cover_image;

        if ($cover && !\Illuminate\Support\Str::startsWith($cover, ['http://', 'https://'])) {
            return asset('storage/manga/' . $cover);
        }

        return $cover ?: asset('images/no-cover.jpg');
    }
}