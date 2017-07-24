<?php

namespace Merkeleon\Forms\Providers;

use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'form');
        $this->publishes([
            dirname(__DIR__) . '/resources/views' => resource_path('views/vendor/form'),
            dirname(__DIR__) . '/config/form.php' => config_path('merkeleon/form.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/config/form.php', 'merkeleon.form'
        );
    }
}
