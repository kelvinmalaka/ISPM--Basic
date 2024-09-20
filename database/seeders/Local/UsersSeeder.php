<?php

namespace Database\Seeders\Local;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserMorph;
use App\Models\SuperAdministrator;
use App\Models\Administrator;
use App\Models\Judge;
use App\Models\Committee;
use App\Models\Contestant;
use App\Models\Role;

class UsersSeeder extends Seeder {
    /**
     * Run the fake user seeds.
     *
     * @return void
     */
    public function run() {
        User::unguard();

        SuperAdministrator::factory()
            ->count(1)
            ->make()
            ->each(fn ($model) => $this->createUser(Role::SUPERADMIN, $model));

        Administrator::factory()
            ->count(2)
            ->make()
            ->each(fn ($model) => $this->createUser(Role::ADMIN, $model));

        Judge::factory()
            ->count(5)
            ->make()
            ->each(fn ($model) => $this->createUser(Role::JUDGE, $model));

        Committee::factory()
            ->count(5)
            ->make()
            ->each(fn ($model) => $this->createUser(Role::COMMITTEE, $model));

        Contestant::factory()
            ->count(25)
            ->make()
            ->each(fn ($model) => $this->createUser(Role::CONTESTANT, $model));
    }

    public function createUser(string $role, UserMorph $morph) {
        $user = User::factory()->create();
        $user->attachRole($role, $morph->toArray());
    }
}
