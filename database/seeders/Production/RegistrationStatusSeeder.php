<?php

namespace Database\Seeders\Production;

use App\Models\RegistrationStatus;
use Illuminate\Database\Seeder;

class RegistrationStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $map = RegistrationStatus::getStatusesMap();
        $statuses = [];

        foreach ($map as $usid => $value) {
            $statuses[] = [
                "usid" => $usid,
                "title" => $value["title"],
                "description" => $value["description"]
            ];
        }

        RegistrationStatus::insert($statuses);
    }
}
