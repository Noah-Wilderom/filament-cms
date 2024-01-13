<?php

namespace NoahWilderom\FilamentCMS;

use Filament\Support\Assets\Theme;

class FilamentCMSTheme extends Theme
{
    public function getHref(): string
    {
        return asset($this->path);
    }
}