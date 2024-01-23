<?php

namespace NoahWilderom\FilamentCMS\Contracts;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface FilamentCMSField
{

    public function scopeResource(Builder $query, string $resource): Builder;
    public function values(): HasMany;
}