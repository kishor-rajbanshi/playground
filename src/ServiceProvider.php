<?php

namespace KishorRajbanshi\LaravelAuth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Console\AboutCommand;
use KishorRajbanshi\LaravelAuth\Console\Commands\InstallCommand;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/auth.php',
            'auth'
        );
    }

    public function boot(): void
    {
        $this->registerCommands();

        $this->registerRateLimitter();

        $this->registerRoutes();

        $this->registerViews();

        $this->registerBladeComponents();

        $this->registerTranslations();

        $this->registerPublishing();
    }

    protected function registerCommands(): void
    {
        AboutCommand::add('Laravel Auth', fn() => [
            'Description' => 'Authentication package for Laravel applications.'
        ]);

        if ($this->app->runningInConsole()) {
            Parent::commands(InstallCommand::class);
        }
    }

    protected function registerRateLimitter(): void
    {
        RateLimiter::for('web', function (Request $request) {
            return Limit::perMinute(60)
                ->by($request->user()?->id ?: $request->ip());
            // ->response(function (Request $request, array $headers) {
            //     return response('Custom response...', 429, $headers);
            // });
        });

        // RateLimiter::for('try-again-letter', function (Request $request) {
        //     return Limit::perMinute(10)
        //         ->by($request->user()?->id ?: $request->ip())
        //         ->after(function (Response $response) {
        //             // Only count 404 responses toward the rate limit to prevent enumeration...
        //             return $response->status() === 404;
        //         });
        // });
    }

    protected function registerRoutes(): void
    {
        Route::middleware(['web', 'throttle:web'])->group(function () {
            Route::name('app.')->group(__DIR__ . '/../routes/app/web.php');
            Route::name('user.')->prefix('/user')->group(__DIR__ . '/../routes/user/web.php');
            Route::name('admin.')->prefix('/admin')->group(__DIR__ . '/../routes/admin/web.php');
        });
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-auth');
    }

    protected function registerBladeComponents(): void
    {
        Blade::componentNamespace('KishorRajbanshi\\LaravelAuth\\View\\Components', 'laravel-auth');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'laravel-auth');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../lang', 'laravel-auth');
    }

    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__ . '/../config/auth.php' => config_path('auth.php'),
        ], 'laravel-auth-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/laravel-auth'),
        ], 'laravel-auth-views');

        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/laravel-auth'),
        ], 'laravel-auth-lang');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/laravel-auth'),
        ], 'laravel-auth-public');

        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'laravel-auth-migrations');
    }
}
