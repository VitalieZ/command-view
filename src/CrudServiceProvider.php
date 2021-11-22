<?php

namespace Viro\Crud;

use Carbon\Laravel\ServiceProvider;
use Viro\Crud\Services\MyModel as MyModelFacade;

class CrudServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands([
            Commands\MyModel::class,
            Commands\MyController::class,
            Commands\MyView::class
        ]);

        $this->app->singleton('mymodel', MyModelFacade::class);
    }


    public function register()
    {
    }
}
