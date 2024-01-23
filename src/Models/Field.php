<?php

namespace NoahWilderom\FilamentCMS\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use NoahWilderom\FilamentCMS\Collections\FieldCollection;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSField;
use NoahWilderom\FilamentCMS\Enums\FieldType;
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
        'type' => FieldType::class
    ];

    public function scopeResource(Builder $query, string $resource): Builder
    {
        return $query->where('model_type', $resource);
    }
    public function newCollection(array $models = []): FieldCollection
    {
        return new FieldCollection($models);
    }

    public function values(): HasMany
    {
        // TODO: Wrap to interface
        return $this->hasMany(FieldValue::class);
    }
}