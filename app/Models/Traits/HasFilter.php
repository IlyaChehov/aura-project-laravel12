<?php

namespace App\Models\Traits;

use App\Http\Filters\CategoryFilter;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    #[Scope]
    protected function ScopeFilter(Builder $query, array $data): Builder
    {
        $ClassName = 'App\\Http\\Filters\\' . class_basename($this) . 'Filter';
        return (new $ClassName())->apply($query, $data);
    }
}
