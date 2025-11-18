<?php

namespace App\Models\Traits;

use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasMedia
{
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function mediaImages(): MorphMany
    {
        return $this->media()->where('type', '=', Media::TYPE_IMAGE);
    }

    public function mediaAvatar(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable')
            ->where('type', '=', Media::TYPE_AVATAR);
    }
}
