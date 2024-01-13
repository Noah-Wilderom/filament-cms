<?php

namespace NoahWilderom\FilamentCMS\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Compilers\BladeCompiler;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSPost;

class FilamentCMSServiceProvider extends ServiceProvider {

    public static string $version = "1.0.0";
    public function boot(): void
    {
        $this->publishConfigFiles();
        $this->publishMigrations();
        $this->publishCommands();
        $this->publishRoutes();
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'filament-cms');
        $this->publishViews();
        $this->publishAssets();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/filament-cms.php', 'filament-cms');
        $this->callAfterResolving('blade.compiler', fn(BladeCompiler $bladeCompiler) => $this->registerBladeExtensions($bladeCompiler));

        $this->app->register(EventServiceProvider::class);

        $this->app->bind(FilamentCMSPost::class, config('filament-cms.post.model'));
    }

    protected function registerBladeExtensions(BladeCompiler $bladeCompiler) {
        $bladeMethodWrapper = '\\NoahWilderom\\FilamentCMS\\FilamentCMSServiceProvider::bladeMethodWrapper';


    }

    protected function publishConfigFiles(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/filament-cms.php' => config_path('filament-cms.php'),
        ], ['filament-cms-config']);
    }

    protected function publishMigrations(): void
    {
        if (! class_exists('CreateMoonGuardTables')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_filament_cms_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_filament_cms_tables.php'),
            ], ['filament-cms-migrations']);
        }
    }

    protected function publishCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }

    protected function publishRoutes(): void
    {
        $apiRoutesConfiguration = [
            'prefix' => config('filament-cms.routes.api.prefix'),
            'middleware' => config('filament-cms.routes.api.middleware'),
        ];

        $webRoutesConfiguration = [
            'prefix' => config('filament-cms.routes.web.prefix'),
            'middleware' => config('filament-cms.routes.web.middleware'),
        ];

        Route::group($apiRoutesConfiguration, function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        });
        Route::group($webRoutesConfiguration, function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        });
    }
    protected function publishViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'filament-cms');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/filament-cms'),
        ], 'filament-cms-views');
    }

    protected function publishAssets(): void
    {
        $this->publishes([
            __DIR__ . '/../../dist/css' => public_path('css/vendor/filament-cms'),
        ], 'filament-cms-assets');
    }
}