<?php

namespace App\Models;

use App\Models\UserMorph;
use App\Models\ContestCategory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Committee extends UserMorph {
    /**
     * Get the contest category that the committee has permmission.
     */
    public function contestCategories() {
        return $this->belongsToMany(ContestCategory::class, CommitteePermission::getTableName())
            ->using(CommitteePermission::class)
            ->as("permission");
    }

    /**
     * Get the contest category that the committee has permmission.
     * 
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany {
        return $this->belongsToMany(ContestCategory::class, CommitteePermission::getTableName())
            ->using(CommitteePermission::class)
            ->as("permission");
    }

    /**
     * Get the registration validations that belongs to the committee.
     * 
     * @return HasMany
     */
    public function registrations(): HasMany {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get the answer validations that belongs to the committee.
     * 
     * @return HasMany
     */
    public function answers(): HasMany {
        return $this->hasMany(AnswerValidation::class);
    }
}
