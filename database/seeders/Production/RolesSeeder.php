<?php

namespace Database\Seeders\Production;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $map = Role::getRolesMap();
        $roles = [];

        foreach ($map as $name => $value) {
            $roles[] = [
                "name" => $name,
                "title" => $value["title"]
            ];
        }

        Role::insert($roles);
    }
}
