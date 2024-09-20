<?php

namespace Database\Seeders\Production;

use App\Models\AnswerStatus;
use Illuminate\Database\Seeder;

class AnswerStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $map = AnswerStatus::getStatusesMap();
        $statuses = [];

        foreach ($map as $usid => $value) {
            $statuses[] = [
                "usid" => $usid,
                "title" => $value["title"],
                "description" => $value["description"]
            ];
        }

        AnswerStatus::insert($statuses);
    }
}
