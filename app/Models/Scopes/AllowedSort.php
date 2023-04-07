<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AllowedSort {
     //local scope
     public function scopeAllowedSorts(Builder $query, string $column)
     {
         return $query->orderBy($column);
     }
}
