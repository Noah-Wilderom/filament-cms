<?php

namespace NoahWilderom\FilamentCMS\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function listens()
    {
        return config('filament-cms.events.listen');
    }
}