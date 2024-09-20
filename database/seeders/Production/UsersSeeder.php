<?php

namespace Database\Seeders\Production;

use App\Models\Role;
use App\Models\SuperAdministrator;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder {
    /**
     * Run the default user seeds.
     *
     * @return void
     */
    public function run() {
        $name = env('DEFAULT_SUPERADMIN_NAME');
        $email = env("DEFAULT_SUPERADMIN_EMAIL");
        $password = env("DEFAULT_SUPERADMIN_PASSWORD");

        if ($name && $email && $password) {
            SuperAdministrator::factory()
                ->count(1)
                ->make()
                ->each(function ($model) use ($name, $email, $password) {
                    $user = User::factory()->setCredentials($name, $email, $password)->create();
                    $user->attachRole(Role::SUPERADMIN, $model->toArray());
                });
        } else {
            throw new \Exception("No Super Administrator credentials set in environment variables.");
        }
    }
}
