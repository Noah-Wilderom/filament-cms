<?php

namespace NoahWilderom\FilamentCMS\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface FilamentCMSPost
{
    public function scopeDrafts(Builder $query): Builder;
    public function scopePublished(Builder $query): Builder;

    public function scopeLimit(Builder $query, int $limit): Builder;

    public function scopeWithArgs(Builder $query, array $args): Builder;
}