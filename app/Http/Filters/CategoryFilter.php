<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends Filter
{
    protected array $keys = [
        'id',
        'title',
        'slug'
    ];

    protected function title(Builder $builder, string $value): void
    {
        $builder->where('title', 'ilike', "%{$value}%");
    }

    protected function id(Builder $builder, string $value): void
    {
        $builder->where('id', 'ilike', "%{$value}%");
    }

    protected function slug(Builder $builder, string $value): void
    {
        $builder->where('slug', 'ilike', "%{$value}%");
    }
}
