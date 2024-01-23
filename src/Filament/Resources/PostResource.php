<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources;

use Filament\Forms\Components\Checkbox;
use Filament\Tables\Actions\RestoreAction;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSField;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSPost;
use NoahWilderom\FilamentCMS\Enums\FieldType;
use NoahWilderom\FilamentCMS\Enums\PostStatus;
use NoahWilderom\FilamentCMS\Enums\PostType;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages\CreatePost;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages\EditPost;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages\ListPosts;
use NoahWilderom\FilamentCMS\Models\Post;

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
        $customFieldsSchema = self::getCustomFieldsSchema();
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
                       Section::make('Meta')
                            ->aside()
                           ->description('Lorem ipsum')
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
                        Section::make('Custom Fields')
                            ->aside()
                            ->description('lorem ipsum')
                            ->schema($customFieldsSchema)
                    ]),
            ]);
    }

    protected static function getCustomFieldsSchema(): array {
        $fields = app(FilamentCMSField::class)->resource(static::getModel())->get();
        $schema = [];
        foreach($fields as $field) {
            $schema[] = match($field->type) {
                FieldType::Text->value => TextInput::make($field->id)
                    ->label($field->title)
                    ->default($field->default),
                FieldType::Boolean->value => Checkbox::make($field->id)
                    ->label($field->title)
                    ->default(!!$field->default),
                FieldType::DateTime->value => DateTimePicker::make($field->id)
                    ->label($field->title)
                    ->default($field->default),
            };
        }

        return $schema;
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
                    ->colors([
                        'primary',
                        'success' => PostStatus::Published->value,
                        'danger' => PostStatus::Closed->value,
                        'warning' => PostStatus::Draft->value,
                    ])
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
                EditAction::make()
                    ->visible(fn (Model $post) => auth()->user()->can('update', $post))
                    ->visible(fn(Model $post) => !$post->trashed()),
                RestoreAction::make()
                    ->requiresConfirmation()
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