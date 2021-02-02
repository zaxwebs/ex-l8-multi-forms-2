<?php

namespace App\Providers;

use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('from', function ($form = null) {
            return old('_name') === $form;
        });

        Blade::if('invalid', function ($name, $form = null) {
            $errors = session()->get('errors', app(ViewErrorBag::class));
            return old('_name') === $form && $errors->has($name);
        });
    }
}
