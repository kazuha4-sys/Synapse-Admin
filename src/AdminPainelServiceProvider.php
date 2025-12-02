<?php

namespace Kazuha\AdminPainel;

use Illuminate\Support\ServiceProvider;
use Kazuha\AdminPainel\Console\InstallCommand;

class AdminPainelServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Rotas
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // Views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'dedsec-admin');

        // Migrations - para packages locais
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        if ($this->app->runningInConsole()) {
            // Registrar comando
            $this->commands([
                InstallCommand::class,
            ]);

            // Publish de views e config se quiser
            $this->publishes([
                __DIR__.'/resources/views' => resource_path('views/vendor/kazuha-admin'),
            ], 'kazuha-admin-views');

            $this->publishes([
                __DIR__.'/database/migrations' => database_path('migrations'),
            ], 'kazuha-admin-migrations');
        }
    }
}
