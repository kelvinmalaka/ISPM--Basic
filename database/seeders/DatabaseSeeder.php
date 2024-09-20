<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $route = "Database\Seeders\\";

        $this->call($route . 'Production\PeriodTypesSeeder');
        $this->call($route . 'Production\RegistrationStatusSeeder');
        $this->call($route . 'Production\AnswerStatusSeeder');
        $this->call($route . 'Production\RolesSeeder');

        if (App::environment('local')) {
            $route .= 'Local\\';

            $this->call($route . 'UsersSeeder');
            $this->call($route . 'ContestSeeder');
            $this->call($route . 'ContestPermissionSeeder');
            $this->call($route . 'TeamSeeder');
            $this->call($route . 'AnswerSeeder');
            $this->call($route . 'AnswerValidationSeeder');
            $this->call($route . 'AssessmentSeeder');
        } else if (App::environment('production')) {
            $route .= 'Production\\';

            $this->call($route . 'UsersSeeder');
        }
    }
}
