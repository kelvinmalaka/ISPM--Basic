<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;

class TeamMember extends Model {
    use HasFactory;

    /**
     * Get the team that owns the member.
     */
    public function team() {
        return $this->belongsTo(Team::class);
    }
}
