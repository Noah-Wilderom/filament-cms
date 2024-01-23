<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\FieldResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\StatsOverviewWidget;
use NoahWilderom\FilamentCMS\Filament\Resources\FieldResource;

class ListFields extends ListRecords {
    protected static string $resource = FieldResource::class;

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
