<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingHistory extends Model
{
    protected $fillable = [
        'user_id',
        'manga_id',
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
}