<?php

namespace App\Models;

use App\Models\UserMorph;
use App\Models\Contest;

class Administrator extends UserMorph {
    /**
     * Get the contests which can be managed.
     */
    public function contests() {
        return $this->hasMany(Contest::class);
    }
}
