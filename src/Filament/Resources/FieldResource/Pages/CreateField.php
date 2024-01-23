<?php
namespace NoahWilderom\FilamentCMS\Filament\Resources\FieldResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use NoahWilderom\FilamentCMS\Filament\Resources\FieldResource;

class CreateField extends CreateRecord
{
    /**
     * The resource model.
     */
    protected static string $resource = FieldResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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
