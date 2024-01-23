<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class CategoryResource extends Resource {

    protected static ?string $slug = 'categories';

    protected static ?string $modelLabel = 'Category';

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $recordTitleAttribute = '';

    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }
    public static function form(Form $form): Form {
        return $form;
    }
    public static function table(Table $table): Table {
        return $table;
    }
    public static function getModel(): string
    {
        return config('filament-cms.category.model');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

//    public static function getPages(): array {
//        return [
//            'index' => ::route('/'),
//            'create' => ::route('/create'),
//            'edit' => ::route('/{record}/edit')
//        ];
//    }
}