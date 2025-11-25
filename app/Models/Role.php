<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    use Sluggable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_MODERATOR = 'moderator';

    protected $table = 'roles';
    protected $fillable = [
        'title',
        'slug'
    ];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
                'unique' => true,
            ]
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'role_user',
            'role_id',
            'user_id'
        )->withTimestamps();
    }
}
