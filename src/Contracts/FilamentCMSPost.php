<?php

namespace NoahWilderom\FilamentCMS\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface FilamentCMSPost
{
    public function scopeDrafts(Builder $query): Builder;
    public function scopePublished(Builder $query): Builder;
}