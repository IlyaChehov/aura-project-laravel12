<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class PostFilter extends Filter
{
    protected array $keys = [
        'title',
        'slug',
        'body',
        'is_published',
        'published_at_to',
        'published_at_from',
        'category_title',
        'username',
    ];

    protected function title(Builder $builder, string $value): void
    {
        $builder->where('title', 'ilike', "%{$value}%");
    }

    protected function slug(Builder $builder, string $value): void
    {
        $builder->where('slug', 'ilike', "%{$value}%");
    }

    protected function body(Builder $builder, string $value): void
    {
        $builder->where('body', 'ilike', "%{$value}%");
    }

    protected function isPublished(Builder $builder, bool $value): void
    {
        $builder->where('is_published', '=', $value);
    }

    protected function publishedAtTo(Builder $builder, string $value): void
    {
        $builder->where('published_at', "<=", $value);
    }

    protected function publishedAtFrom(Builder $builder, string $value): void
    {
        $builder->where('published_at', ">=", $value);
    }

    protected function categoryTitle(Builder $builder, string $value): void
    {
        $builder->whereHas('category', function(Builder $b) use($value) {
            $b->where('title', 'ilike', "%{$value}%");
        });
    }

    protected function username(Builder $builder, string $value): void
    {
        $builder->whereHas('user', function(Builder $b) use($value) {
            $b->where('name', 'ilike', "%{$value}%");
        });
    }
}
