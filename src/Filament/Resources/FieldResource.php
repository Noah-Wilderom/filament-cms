<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use NoahWilderom\FilamentCMS\Enums\FieldType;
use NoahWilderom\FilamentCMS\Filament\Resources\FieldResource\Pages\CreateField;
use NoahWilderom\FilamentCMS\Filament\Resources\FieldResource\Pages\EditField;
use NoahWilderom\FilamentCMS\Filament\Resources\FieldResource\Pages\ListFields;

class FieldResource extends Resource {

    protected static ?string $slug = 'fields';

    protected static ?string $modelLabel = 'Field';

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $recordTitleAttribute = '';

    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }
    public static function form(Form $form): Form {
        return $form
            ->schema([
                Grid::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->placeholder('Enter a title')
                            ->live()
                            ->required()
                            ->maxLength(255)
                            ->autofocus()
                            ->afterStateUpdated(function (Get $get, Set $set, string $operation, ?string $old, ?string $state) {
                                if(($get('name') ?? '') !== Str::snake($old) || $operation !== 'create') {
                                    return;
                                }
                                $set('name', Str::snake($state));
                            }),
                        TextInput::make('name')
                            ->placeholder("Enter a name")
                            ->live()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),
                Grid::make()
                    ->columns(2)
                    ->schema([
                        Select::make('model_type')
                            ->placeholder('Select a Resource')
                            ->live()
                            ->searchable()
                            ->options(function() {
                                $resources = [];
                                $configResources = config('filament-cms.field.resources');
                                foreach($configResources as $resource) {
                                    $pieces = explode('\\', $resource);
                                    $resources[$resource] = end($pieces);
                                }
                                return $resources;
                            }),
                        Select::make('type')
                            ->placeholder('Enter a type')
                            ->live()
                            ->default(FieldType::Text->value)
                            ->searchable()
                            ->required()
                            ->options(FieldType::casesToString()),
                    ]),
                Grid::make()
                    ->columns(1)
                    ->schema([
                        TextInput::make('default_textinput')
                            ->default('')
                            ->visible(fn (Get $get) => $get('type') === FieldType::Text->value)
                            ->label('Default value'),

                        Toggle::make('default_toggle')
                            ->default(false)
                            ->visible(fn (Get $get) => $get('type') === FieldType::Boolean->value)
                            ->label('Default value'),

                        DateTimePicker::make('default_datetime')
                            ->default(now())
                            ->visible(fn (Get $get) => $get('type') === FieldType::DateTime->value)
                            ->label('Default value'),
                    ])
            ]);
    }
    public static function table(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->sortable()
                    ->badge()
                    ->searchable(),
                TextColumn::make('default')
                    ->sortable(),
                TextColumn::make('model_type')
                    ->label('Resource')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation(),
            ]);
    }
    public static function getModel(): string
    {
        return config('filament-cms.field.model');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => ListFields::route('/'),
            'create' => CreateField::route('/create'),
            'edit' => EditField::route('/{record}/edit')
        ];
    }
}