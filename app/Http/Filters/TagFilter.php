<?php

namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class TagFilter extends Filter
{
    protected array $keys = [
        'title',
    ];

    protected function title(Builder $builder, string $value): void
    {
        $builder->where('title', 'ilike', "%{$value}%");
    }
}
