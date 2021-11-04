<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tweet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content',
    ];

    /**
     * get The User that posted the tweet
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get Users that liked the tweet
     *
     * @return BelongsToMany
     */
    public function likedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    /**
     * Judge whether the user in param has liked the tweet
     *
     * @param User $user
     * @return bool
     */
    public function isLiked(User $user): bool
    {
        return $this
            ->likedUsers()
            ->where('user_id', $user->id)
            ->exists();
    }
}
