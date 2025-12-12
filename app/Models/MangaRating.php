<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MangaRating extends Model
{
    protected $fillable = [
        'user_id',
        'manga_id',
        'rating',
        'review',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }

    // Validation rules
    public static function rules()
    {
        return [
            'rating' => 'required|integer|min:1|max:10',
            'review' => 'nullable|string|max:1000',
        ];
    }
}