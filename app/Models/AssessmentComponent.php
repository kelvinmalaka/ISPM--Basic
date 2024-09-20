<?php

namespace App\Models;

use App\Models\Traits\GuardDelete;
use App\Models\Assessment;
use App\Models\JudgePermission;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentComponent extends Model {
    use HasFactory, GuardDelete;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get the contest category that owns the assessment component.
     * 
     * @return BelongsTo
     */
    public function contestCategory(): BelongsTo {
        return $this->belongsTo(ContestCategory::class);
    }

    /**
     * Get the judges that has permission to assess the component.
     * 
     * @return BelongsToMany
     */
    public function judges(): BelongsToMany {
        return $this->belongsToMany(Judge::class, JudgePermission::getTableName())
            ->using(JudgePermission::class)
            ->as("permission");
    }

    /**
     * Get the assessments that belongs to this component has permmission.
     * 
     * @return HasMany
     */
    public function assessments(): HasMany {
        return $this->hasMany(Assessment::class, "assessment_component_id");
    }

    /**
     * Determine if an assessment component can be deleted.
     * 
     * @return  bool
     * @throws  Exception
     */
    public function canBeDeleted() {
        $reason = "";

        $assessments = $this->assessments->count();
        if ($assessments) {
            $reason = "Already have " . $assessments . " judge assessments.";
        }

        if ($reason) throw new Exception("Failed. " . $reason);

        return true;
    }
}
