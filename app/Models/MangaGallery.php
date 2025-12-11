<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MangaGallery extends Model
{
    protected $fillable = [
        'manga_id',
        'uploaded_by',
        'image_path',
        'title',
        'description',
        'order',
        'type',
    ];

    // Relationship ke Manga
    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }

    // Relationship ke User (uploader)
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Accessor untuk image URL
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    // Scope untuk ordering
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}