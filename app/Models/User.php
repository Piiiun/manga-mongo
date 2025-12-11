<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role',
        'profile_picture',
        'bio',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class)->orderBy('last_read_at', 'desc');
    }

    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        
        // Default avatar using UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=200&background=f59e0b&color=000';
    }

    public function trackReading($mangaId, $chapterNumber, $page = 1)
    {
        return $this->readingHistories()->updateOrCreate(
            [
                'manga_id' => $mangaId,
                'chapter_number' => $chapterNumber,
            ],
            [
                'last_page' => $page,
                'last_read_at' => now(),
            ]
        );
    }

    public function getLastReadChapter($mangaId)
    {
        return $this->readingHistories()
            ->where('manga_id', $mangaId)
            ->orderBy('last_read_at', 'desc')
            ->first();
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_likes')->withTimestamps();
    }
    
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function galleryUploads()
    {
        return $this->hasMany(MangaGallery::class, 'uploaded_by');
    }
}
