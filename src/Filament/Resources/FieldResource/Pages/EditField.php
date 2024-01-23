<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\FieldResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use NoahWilderom\FilamentCMS\Enums\FieldType;
use NoahWilderom\FilamentCMS\Filament\Resources\FieldResource;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource;

class EditField extends EditRecord
{

    /**
     * The resource model.
     */
    protected static string $resource = FieldResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // TODO: Refactor this
        if($data['type'] === FieldType::Text->value) {
            $data['default_textinput'] = $data['default'];
        } else if($data['type'] === FieldType::DateTime->value) {
            $data['default_datetime'] = $data['default'];
        } else if ($data['type'] === FieldType::Boolean->value) {
            $data['default_toggle'] = $data['default'];
        }


        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // TODO: Refactor this
        foreach($data as $key => $value) {
            if($key == 'default_textinput' && !empty($value)) {
                $data['default'] = $value;
            } else if ($key == 'default_datetime' && !empty($value)) {
                $data['default'] = $value;
            } else if($key == 'default_toggle' && !empty($value)) {
                $data['default'] = $value;
            }
        }

        return $data;
    }
}