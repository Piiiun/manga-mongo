<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'manga_id',
        'chapter_id',
        'parent_id',
        'content',
        'is_spoiler',
        'likes',
    ];

    protected $casts = [
        'is_spoiler' => 'boolean',
    ];

    protected $with = ['user']; // Eager load user

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
        return $this->belongsTo(Chapter::class);
    }

    // Parent comment (untuk reply)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Replies
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    // Likes
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'comment_likes')->withTimestamps();
    }

    // Check if user liked
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likedByUsers()->where('user_id', $user->id)->exists();
    }

    // Scope untuk top-level comments (bukan reply)
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    // Scope untuk manga comments (bukan chapter)
    public function scopeForManga($query)
    {
        return $query->whereNull('chapter_id');
    }

    // Scope untuk chapter comments
    public function scopeForChapter($query, $chapterId)
    {
        return $query->where('chapter_id', $chapterId);
    }
}