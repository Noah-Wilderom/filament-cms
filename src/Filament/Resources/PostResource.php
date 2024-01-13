<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use NoahWilderom\FilamentCMS\Enums\PostStatus;
use NoahWilderom\FilamentCMS\Enums\PostType;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages\CreatePost;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages\EditPost;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages\ListPosts;

class PostResource extends Resource
{
    protected static ?string $slug = 'posts';

    protected static ?string $modelLabel = 'Post';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }

    public static function form(Form $form): Form {
        return $form
            ->schema([
                Grid::make()
                    ->columns(3)
                    ->schema([
                        TextInput::make('title')
                            ->placeholder(trans('filament-cms::post.form.title.placeholder'))
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, string $operation, ?string $old, ?string $state) {
                                if(($get('slug') ?? '') !== Str::slug($old) || $operation !== 'create') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            })
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),
                        TextInput::make('slug')
                            ->placeholder('Enter a slug')
                            ->alphaDash()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Builder::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->default([
                                ['type' => 'html'],
                            ])
                            ->blocks([
                                Builder\Block::make('markdown')
                                    ->schema([
                                        MarkdownEditor::make('content')
                                            ->required(),
                                    ]),

                                Builder\Block::make('html')
                                    ->schema([
                                        RichEditor::make('content')
                                            ->required(),
                                    ]),

                                Builder\Block::make('image')
                                    ->schema([
                                        FileUpload::make('file')
                                            ->image()
                                            ->required(),
//                                            ->responsiveImages(),

                                        Fieldset::make()
                                            ->label('Details')
                                            ->schema([
                                                TextInput::make('alt')
                                                    ->label('Alt Text')
                                                    ->placeholder('Enter alt text')
                                                    ->required()
                                                    ->maxLength(255),

                                                TextInput::make('caption')
                                                    ->placeholder('Enter a caption')
                                                    ->maxLength(255),
                                            ]),

                                    ]),
                            ]),
                       Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Author')
                                    ->relationship('user', 'name')
                                    ->default(fn () => auth()->id())
                                    ->searchable()
                                    ->required(),

                                SpatieMediaLibraryFileUpload::make('image_id')
                                    ->responsiveImages()
                                    ->label('Featured Image'),

                                DateTimePicker::make('published_at')
                                    ->label('Publish Date')
                                    ->seconds(false)
                                    ->timezone('Europe/Amsterdam')
                                    ->format('d-m-Y H:i:s')
                                    ->default(now())
                                    ->native(false)
                                    ->required(),

                                Select::make('type')
                                    ->label('Type')
                                    ->default(fn () => PostType::Post->value)
                                    ->searchable()
                                    ->required()
                                    ->options(PostType::casesToString()),

                                Select::make('status')
                                    ->label('Status')
                                    ->default(fn () => PostStatus::Draft->value)
                                    ->searchable()
                                    ->required()
                                    ->options(PostStatus::casesToString()),
                            ]),
                    ]),
            ]);
    }

    /**
     * Get the table for the resource.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Author')
                    ->badge()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getModel(): string
    {
        return config('filament-cms.post.model');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit')
        ];
    }
}