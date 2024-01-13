<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource;

class CreatePost extends CreateRecord
{
    /**
     * The resource model.
     */
    protected static string $resource = PostResource::class;
}