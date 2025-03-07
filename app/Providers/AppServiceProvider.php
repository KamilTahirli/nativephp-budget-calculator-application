<?php

namespace App\Providers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\PhotoUploadInterface;
use App\Interfaces\TransactionInterface;
use App\Interfaces\UserInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\User\UserRepository;
use App\Services\Common\PhotoUploadService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PhotoUploadInterface::class, PhotoUploadService::class);
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
