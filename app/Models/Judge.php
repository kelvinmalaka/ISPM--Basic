<?php

namespace App\Models;

use App\Models\UserMorph;
use App\Models\Assessment;
use App\Models\AssessmentComponent;
use App\Models\JudgePermission;

class Judge extends UserMorph {
    /**
     * Get the assessments of judge.
     */
    public function assessments() {
        return $this->hasMany(Assessment::class);
    }

    /**
     * Get the assessment components that the judge has permmission.
     */
    public function assessmentComponents() {
        return $this->belongsToMany(AssessmentComponent::class, JudgePermission::getTableName())
            ->using(JudgePermission::class)
            ->as("permission");
    }
}
