<?php

namespace NoahWilderom\FilamentCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use NoahWilderom\FilamentCMS\Collections\FieldCollection;
use NoahWilderom\FilamentCMS\Enums\FieldType;
use NoahWilderom\FilamentCMS\Traits\HasDynamicId;

class FieldValue extends Model
{
    use HasFactory, HasDynamicId;

    public static string $configKey = 'field_values';
    protected $fillable = [
        'model_id',
        'value'
    ];

    public function field(): BelongsTo {
        return $this->belongsTo(Field::class);
    }

    public function toValue(): mixed {
        return match ($this->field->type) {
            FieldType::Text => strval($this->value),
            FieldType::Boolean => boolval($this->value),
            FieldType::DateTime => Carbon::parse($this->value),
            null => null,
            default => $this->value
        };
    }
}