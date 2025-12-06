<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{
    use HasFactory;
    protected $fillable = [
        'manga_id',
        'number',
        'title',
        'slug',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
    ];

    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function getUrlAttribute()
    {
        return route('manga.read', [
            'manga_slug' => $this->manga->slug,
            'chapter_number' => $this->number
        ]);
    }

    // // Komentar di chapter ini
    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }

    // public function readingHistories()
    // {
    //     return $this->hasMany(ReadingHistory::class);
    // }
}
