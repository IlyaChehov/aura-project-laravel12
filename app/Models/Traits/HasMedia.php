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

    public function setImageBatch(array $dataBatch): void
    {
        $count = 1;
        foreach ($dataBatch as $image) {
            $this->media()->create([
                'type' => Media::TYPE_IMAGE,
                'path' => $image['path'],
                'original_name' => $image['original_name'],
                'size' => $image['size'] ?? null,
                'mime_type' => $image['mime_type'] ?? null,
                'order_column' => $count,
            ]);
            $count++;
        }
    }

    public function setImage(array $data): void
    {
        $this->media()->create([
            'type' => Media::TYPE_IMAGE,
            'path' => $data['path'],
            'original_name' => $data['original_name'],
            'size' => $data['size'] ?? null,
            'mime_type' => $data['mime_type'] ?? null,
            'order_column' => $data['order_column'] ?? null,
        ]);
    }

    public function images(): MorphMany
    {
        return $this->media()->where('type', '=', Media::TYPE_IMAGE);
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function setAvatar(array $avatar)
    {
        $this->media()->create([
            'type' => Media::TYPE_AVATAR,
            'path' => $avatar['path'],
            'original_name' => $avatar['original_name'],
            'size' => $avatar['size'] ?? null,
            'mime_type' => $avatar['mime_type'] ?? null,
        ]);
    }
}
