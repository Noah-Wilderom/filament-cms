<?php

namespace NoahWilderom\FilamentCMS\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface FilamentCMSPost
{
    public function scopeDrafts(Builder $query): Builder;
    public function scopePublished(Builder $query): Builder;

    public function scopeLimit(Builder $query, int $limit): Builder;

    public function scopeWithArgs(Builder $query, array $args): Builder;

    public function fields(): HasMany;

    public function field(string $name);
}