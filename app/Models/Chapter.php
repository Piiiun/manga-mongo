<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'manga_id',
        'number',
        'title',
        'slug',
        'published_at',
    ];

    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
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
