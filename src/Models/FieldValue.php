<?php

namespace NoahWilderom\FilamentCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NoahWilderom\FilamentCMS\Collections\FieldCollection;
use NoahWilderom\FilamentCMS\Traits\HasDynamicId;

class FieldValue extends Model
{
    use HasFactory, HasDynamicId;

    public static string $configKey = 'field';
    protected $guarded = [];
    protected $fillable = [
        ''
    ];

    protected $casts = [
        ''
    ];

    public function newCollection(array $models = []): FieldCollection
    {
        return new FieldCollection($models);
    }
}