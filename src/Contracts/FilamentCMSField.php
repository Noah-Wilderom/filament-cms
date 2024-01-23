<?php

namespace NoahWilderom\FilamentCMS\Contracts;


use Illuminate\Database\Eloquent\Builder;

interface FilamentCMSField
{

    public function scopeResource(Builder $query, string $resource): Builder;
}