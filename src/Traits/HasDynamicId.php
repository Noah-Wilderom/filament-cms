<?php

namespace NoahWilderom\FilamentCMS\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasDynamicId
{
    protected static function boot() {
        parent::boot();

        $config = self::getConfig();
        if(is_null($config)) return;

        if($config['id'] != 'id') {
            static::creating(function (Model $model) use($config) {
                if (empty($model->{$model->getKeyName()})) {
                    $model->{$model->getKeyName()} = match ($config['id']) {
                        'uuid' => Str::uuid()->toString(),
                        'ulid' => strval(Str::ulid()),
                        default => null,
                    };
                }
            });
        }

    }

    private static function getConfig(): ?array {
        if(! property_exists(self::class, 'configKey')) {
           return null;
        }

        return config(sprintf('filament-cms.%s', self::$configKey));
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        $config = self::getConfig();
        if(is_null($config)) return false;

        return $config['id'] === 'id';
    }
    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        $config = self::getConfig();
        if(is_null($config)) return 'int';

        return $config['id'] === 'id' ? 'int' : 'string';
    }

    public function getPrimaryKey()
    {
        return 'id';
    }

    public function getKeyName()
    {
        return 'id';
    }
}