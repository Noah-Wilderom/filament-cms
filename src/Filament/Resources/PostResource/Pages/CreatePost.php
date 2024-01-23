<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSField;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource;
use function Symfony\Component\String\u;

class CreatePost extends CreateRecord
{
    /**
     * The resource model.
     */
    protected static string $resource = PostResource::class;


    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $model = static::getModel()::create($data);

        foreach($data as $key => $value) {
            if (uuid_is_valid($key)) {
                if($field = app(FilamentCMSField::class)->find($key)) {
                    $field->values()->create([
                        'model_id' => $model->id,
                        'value' => $value,
                    ]);
                }
            }
        }

        return $model;
    }
}