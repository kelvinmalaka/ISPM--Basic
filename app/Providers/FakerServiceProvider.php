<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Faker\{Factory, Generator};
use App\Faker\ContestProvider;
use App\Faker\ContestCategoryProvider;

class FakerServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create("id_ID");
            $faker->addProvider(new ContestProvider($faker));
            $faker->addProvider(new ContestCategoryProvider($faker));

            return $faker;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void {
        //
    }
}
