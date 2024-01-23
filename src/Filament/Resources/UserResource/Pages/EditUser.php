<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\EditRecord;
use NoahWilderom\FilamentCMS\Filament\Resources\UserResource;

class EditUser extends EditRecord
{

    /**
     * The resource model.
     */
    protected static string $resource = UserResource::class;
}