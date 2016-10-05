<?php

namespace ControleProjetos\Providers;

use Illuminate\Support\ServiceProvider;

class ControleProjetosRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \ControleProjetos\Repositories\ClientRepository::class,
            \ControleProjetos\Repositories\ClientRepositoryEloquent::class
        );

        $this->app->bind(
            \ControleProjetos\Repositories\ProjectRepository::class,
            \ControleProjetos\Repositories\ProjectRepositoryEloquent::class
        );

        $this->app->bind(
            \ControleProjetos\Repositories\ProjectNoteRepository::class,
            \ControleProjetos\Repositories\ProjectNoteRepositoryEloquent::class
        );
    }

}
