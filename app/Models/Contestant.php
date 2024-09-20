<?php

namespace App\Models;

use App\Models\UserMorph;
use App\Models\Team;

class Contestant extends UserMorph {
    /**
     * Get the teams registration of contestant.
     */
    public function teams() {
        return $this->hasMany(Team::class);
    }
}
