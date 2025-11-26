<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasLikes
{
    public function likes(): MorphToMany
    {
        return $this->morphToMany(User::class, 'likeable', 'likeables')->withTimestamps();
    }

    public function likeBy(User $user): void
    {
        $this->likes()->syncWithoutDetaching([$user->id]);
    }

    public function unlikeBy(User $user): void
    {
        $this->likes()->detach($user->id);
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }
}
