<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
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
        'description',
        'source',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }
}
