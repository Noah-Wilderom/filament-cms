<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSPost;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource;

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
//            PostOverview::class,
        ];
    }

    public function getTabs(): array {
        return [
            'all' => Tab::make(),
            'trashed' => Tab::make()
                ->icon('heroicon-m-trash')
                ->badge(app(FilamentCMSPost::class)->onlyTrashed()->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed())
        ];
    }
}