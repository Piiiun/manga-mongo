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

    public function getFormattedViewsAttribute()
    {
        $views = $this->views;
        
        if ($views >= 1000000000) {
            return number_format($views / 1000000000, 1) . 'B';
        }
        
        if ($views >= 1000000) {
            return number_format($views / 1000000, 1) . 'M';
        }
        
        if ($views >= 1000) {
            return number_format($views / 1000, 1) . 'K';
        }
        
        return number_format($views);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('chapter_id');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class); // Include chapter comments
    }

    public function galleries()
    {
        return $this->hasMany(MangaGallery::class)->ordered();
    }
}
