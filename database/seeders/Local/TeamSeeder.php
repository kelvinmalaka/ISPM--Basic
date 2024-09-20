<?php

namespace Database\Seeders\Local;

use Illuminate\Database\Seeder;
use App\Models\ContestCategory;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\Registration;

class TeamSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        ContestCategory::all()->each(function (ContestCategory $category) {
            Team::factory()
                ->for($category)
                ->has(TeamMember::factory()->count(2), "members")
                ->has(Registration::factory())
                ->count(3)
                ->create();
        });
    }
}
