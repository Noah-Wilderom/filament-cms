<?php
namespace NoahWilderom\FilamentCMS\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use NoahWilderom\FilamentCMS\Filament\Resources\UserResource;

class CreateUser extends CreateRecord
{
    /**
     * The resource model.
     */
    protected static string $resource = UserResource::class;
}