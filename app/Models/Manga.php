<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'author',
        'artist',
        'status',
        'released_at',
        'views',
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


    // // History bacaan user
    // public function readingHistories()
    // {
    //     return $this->hasMany(ReadingHistory::class);
    // }
}
