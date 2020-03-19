<?php namespace SPRIGS\Module\Creator;

use Illuminate\Support\ServiceProvider;

use SPRIGS\Module\Creator\Commands\CreateModuleCommand;
use SPRIGS\Module\Creator\Commands\CreateRepositoryCommand;
use SPRIGS\Module\Creator\Commands\CreateServiceCommand;

class ModuleCreatorServiceProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        if ( $this->app->runningInConsole() ) {
            $this->commands([
                CreateModuleCommand ::class,
                CreateServiceCommand ::class,
                CreateRepositoryCommand ::class,
            ]);
        }
    }
}
