<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Pages\Page;
use Filament\Resources\Pages\ListRecords;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Widgets\PostOverview;

class ListPosts extends ListRecords {
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PostOverview::class,
        ];
    }
}