<?php

namespace App\Providers;

use App\Models\Config;
use Illuminate\Support\Facades\Artisan;
use Native\Laravel\Facades\Menu;
use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
//        Artisan::call('migrate', ['--force' => true]);
//        Artisan::call('native:migrate', ['--force' => true]);
//        Artisan::call('native:db:seed', ['--force' => true]);
//        Artisan::call('optimize:clear');

        $config = Config::where('seeded', false)->first();
        if ($config) {
            Artisan::call('db:seed', ['--force' => true]);
        }

        Menu::create(
            Menu::file(),
            Menu::view(),
            Menu::window(),
        );

        Window::open()
            ->hideDevTools()
            ->maximized();

    }


    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }
}
