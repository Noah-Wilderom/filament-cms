<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\UserResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use NoahWilderom\FilamentCMS\Filament\Resources\UserResource;

class ListUsers extends ListRecords {
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
        ];
    }
}
