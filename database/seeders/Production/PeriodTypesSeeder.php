<?php

namespace Database\Seeders\Production;

use App\Models\PeriodType;
use Illuminate\Database\Seeder;

class PeriodTypesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $map = PeriodType::getTypesMap();
        $periodTypes = [];

        foreach ($map as $usid => $value) {
            $periodTypes[] = [
                "usid" => $usid,
                "title" => $value["title"],
                "description" => $value["description"]
            ];
        }

        PeriodType::insert($periodTypes);
    }
}
