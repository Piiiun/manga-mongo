<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'chapter_id',
        'page_number',
        'image_path',
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function manga()
    {
        return $this->hasOneThrough(Manga::class, Chapter::class, 'id', 'id', 'chapter_id', 'manga_id');
        // jarang dibutuhkan, sekadar contoh
    }
}
