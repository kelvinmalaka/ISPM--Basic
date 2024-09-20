<?php

namespace App\Models;

use App\Models\Answer;
use App\Models\AssessmentComponent;
use App\Models\Judge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model {
    use HasFactory;

    /**
     * Get the judge that owns the assessment.
     * 
     * @return BelongsTo
     */
    public function judge(): BelongsTo {
        return $this->belongsTo(Judge::class);
    }

    /**
     * Get the assessment component of the assessment.
     * 
     * @return BelongsTo
     */
    public function component(): BelongsTo {
        return $this->belongsTo(AssessmentComponent::class, "assessment_component_id");
    }

    /**
     * Get the answer that owns the assessment.
     * 
     * @return BelongsTo
     */
    public function answer(): BelongsTo {
        return $this->belongsTo(Answer::class);
    }
}
