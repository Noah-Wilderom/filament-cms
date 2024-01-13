<?php

namespace NoahWilderom\FilamentCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NoahWilderom\FilamentCMS\Collections\FieldCollection;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSField;

class Field extends Model implements FilamentCMSField
{
    use HasFactory, DynamicId;

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