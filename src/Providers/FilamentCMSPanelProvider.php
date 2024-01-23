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
use NoahWilderom\FilamentCMS\Filament\Resources\FieldResource;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource;
use NoahWilderom\FilamentCMS\Filament\Resources\UserResource;
use NoahWilderom\FilamentCMS\FilamentCMSTheme;
use Pboivin\FilamentPeek\FilamentPeekPlugin;

class FilamentCMSPanelProvider extends PanelProvider
{
    public function __construct($app)
    {
//        $this->checkAvailability();
        parent::__construct($app);
    }

    protected array $pages = [
        //
    ];

    protected array $resources = [
        PostResource::class,
        FieldResource::class,
        UserResource::class,
    ];

    protected array $widgets = [
        //
    ];

    protected function checkAvailability(): void
    {
        $resources = [];
       foreach($this->resources as $resource)  {
           if(property_exists($resource::getModel(), 'configKey')) {
               $isEnabled = config(sprintf('filament-cms.%s.enabled', $resource::getModel()::$configKey));
               if(! $isEnabled) {
                   continue;
               }
           }

           $resources[] = $resource;
       }

       $this->resources = $resources;
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('filament-cms')
            ->path(config('filament-cms.cms.path'))
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