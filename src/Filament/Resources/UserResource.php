<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use NoahWilderom\FilamentCMS\Filament\Resources\UserResource\Pages\CreateUser;
use NoahWilderom\FilamentCMS\Filament\Resources\UserResource\Pages\EditUser;
use NoahWilderom\FilamentCMS\Filament\Resources\UserResource\Pages\ListUsers;

class UserResource extends Resource {

    protected static ?string $slug = 'users';

    protected static ?string $modelLabel = 'Users';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $recordTitleAttribute = '';

    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }
    public static function form(Form $form): Form {
        return $form;
    }
    public static function table(Table $table): Table {
        $columns = [
            TextColumn::make('id')
                ->label('ID')
                ->searchable(),
            TextColumn::make('name')
                ->sortable()
                ->searchable(),
            TextColumn::make('email')
                ->sortable()
                ->searchable(),

        ];

        if(config('filament-cms.user.verified')) {
           $columns[] = TextColumn::make('email_verified_at')
               ->formatStateUsing(fn (?string $state) => is_null($state) ? 'Unverified' : 'Verified')
               ->label('Email Verified')
               ->icon(fn ($state) => is_null($state) ? 'heroicon-o-cross-circle' : 'heroicon-o-check-circle')
               ->colors(fn ($state) => is_null($state) ? 'danger' : 'success');
        }

        return $table
            ->columns($columns)
            ->actions([
                EditAction::make()
            ]);
    }
    public static function getModel(): string
    {
        return config('filament-cms.user.model');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit')
        ];
    }
}