<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;
    use Sluggable;

    public const GENDER_NOT_SPECIFIED = 0;
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    protected $table = 'profiles';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'slug',
        'country',
        'city',
        'birthed_at',
        'is_married',
        'gender'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFullNameAttribute(): string
    {
        $fullName = trim($this->first_name . ' ' . $this->last_name);
        return $fullName ?: 'user';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'full_name',
                'onUpdate' => true,
                'unique' => true,
                'maxLength' => 100,
            ]
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
