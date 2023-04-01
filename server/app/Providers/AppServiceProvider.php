<?php

namespace App\Providers;

use App\Models\Trello;
use App\Telegram;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Telegram::class, function () {
            return new Telegram(new Http());
        });
        $this->app->bind(Trello::class, function () {
            return new Trello();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
