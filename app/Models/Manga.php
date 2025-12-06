<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manga extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'alternative_title',
        'description',
        'cover_image',
        'author',
        'artist',
        'status',
        'type',
        'rating',
        'released_at',
        'serialization',
        'total_chapter',
        'last_update',
        'views',
    ];

    protected $casts = [
        'last_update' => 'datetime',
        'released_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function pages()
    {
        return $this->hasManyThrough(Page::class, Chapter::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_manga');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    // // History bacaan user
    // public function readingHistories()
    // {
    //     return $this->hasMany(ReadingHistory::class);
    // }
}
