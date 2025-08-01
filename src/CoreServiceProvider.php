<?php

namespace ArcdevPackages\Core;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/core.php', 'core');
    }

    public function boot(): void
    {
        // Always safe to load routes, views, translations, migrations
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        //$this->loadViewsFrom(__DIR__.'/resources/views', 'core');
        $this->loadTranslationsFrom(__DIR__.'/lang/defaults', 'core');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Blade component namespace (safe)
        if (class_exists(Blade::class) && method_exists(Blade::class, 'componentNamespace')) {
            Blade::componentNamespace('ArcdevPackages\\Core\\View\\Components', 'core');
        }

        // 🛡️ Only run publishing if we are running in console (php artisan commands)
        if ($this->app->runningInConsole()) {
            $this->app->booted(function () {
                $this->publishes([
                    //__DIR__.'/app/Traits' => base_path('Traits'),
                    //__DIR__.'/app/Enums' => base_path('Enums'),
                    __DIR__.'/resources/js/Composables' => resource_path('js/Composables'),
                    __DIR__.'/resources/js/Components' => resource_path('js/Components'),
                    __DIR__.'/resources/css/hasCoreCustom.css' => base_path('resources/scss/hasCoreCustom.css'),
                    __DIR__.'/config/core.php' => base_path('config/comment.php'),
                ], 'arcdev-packages/publishable-files');
            });
        }
    }
}
