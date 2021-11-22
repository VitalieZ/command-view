<?php

namespace Viro\Crud;

use Carbon\Laravel\ServiceProvider;
use Viro\Crud\Facades\MyModel as MyModelFacade;

class CrudServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands([
            Commands\MyModel::class,
            Commands\MyController::class,
            Commands\MyView::class
        ]);

        //register facades
        $this->registerfacades();
    }


    public function register()
    {
    }

    public function registerfacades()
    {
        $this->app->singleton('mymodel', MyModelFacade::class);
    }
}
