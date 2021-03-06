<?php

namespace ControleProjetos\Providers;

use ControleProjetos\Entities\ProjectTask;
use ControleProjetos\Events\TaskChanged;
use ControleProjetos\Events\TaskWasIncluded;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ProjectTask::created(function($task){
            Event::fire(new TaskWasIncluded($task));
        });

        ProjectTask::updated(function($task){
            Event::fire(new TaskChanged($task));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
