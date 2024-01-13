<?php

namespace NoahWilderom\FilamentCMS\Providers;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\Authenticate;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource;
use NoahWilderom\FilamentCMS\FilamentCMSTheme;
use Pboivin\FilamentPeek\FilamentPeekPlugin;

class FilamentCMSPanelProvider extends PanelProvider
{
    protected array $pages = [
        //
    ];

    protected array $resources = [
        PostResource::class
    ];

    protected array $widgets = [
        //
    ];

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('filament-cms')
            ->path('cms')
            ->brandName(sprintf('Filament CMS v%s', getVersionMajor()))
            ->login()
            ->plugins([
//                FilamentPeekPlugin::make(),
            ])
            ->pages($this->pages)
            ->resources($this->resources)
            ->widgets($this->widgets)
            ->colors([
                'primary' => Color::Slate,
            ])
            ->theme(new FilamentCMSTheme('filament_cms', 'css/vendor/filament-cms/theme.css'))
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}