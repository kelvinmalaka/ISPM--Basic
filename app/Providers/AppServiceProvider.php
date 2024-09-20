<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191);

        Carbon::setLocale("id");

        Carbon::macro("toLocale", function ($date) {
            if ($date) return Carbon::parse($date)->translatedFormat("d F Y - H:i") . " WIB";
            return "-";
        });

        Carbon::macro("toDateLocale", function ($date) {
            if ($date) return Carbon::parse($date)->translatedFormat("d F Y");
            return "-";
        });
    }
}
