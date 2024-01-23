<?php

namespace NoahWilderom\FilamentCMS\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NoahWilderom\FilamentCMS\Collections\FieldCollection;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSField;
use NoahWilderom\FilamentCMS\Traits\HasDynamicId;

class Field extends Model implements FilamentCMSField
{
    use HasFactory, HasDynamicId;

    public static string $configKey = 'field';
    protected $fillable = [
        'model_type',
        'name',
        'title',
        'default',
        'type'
    ];

    protected $casts = [
        ''
    ];

    public function scopeResource(Builder $query, string $resource): Builder
    {
        return $query->where('model_type', $resource);
    }
    public function newCollection(array $models = []): FieldCollection
    {
        return new FieldCollection($models);
    }
}