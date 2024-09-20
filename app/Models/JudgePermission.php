<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Kirschbaum\PowerJoins\PowerJoins;
use App\Models\Traits\GuardDelete;
use App\Models\Assessment;
use App\Models\AssessmentComponent;
use App\Models\Judge;
use Exception;

class JudgePermission extends Pivot {
    use PowerJoins, GuardDelete;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "judge_permissions";

    /**
     * Get table name of the model.
     *
     * @return string
     */
    public static function getTableName(): string {
        return "judge_permissions";
    }

    /**
     * Override primary key attribute using composite key
     * 
     * @return string
     */
    public function getKey(): string {
        return $this->assessmentComponent->id . "_" . $this->judge->id;
    }

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Determine if a judge permission can be deleted.
     * 
     * @return  bool
     * @throws  Exception
     */
    public function canBeDeleted() {
        $reason = "";

        $assessments = $this->assessments->count();
        if ($assessments) {
            $reason = "Already submitted " . $assessments . " assessments.";
        }

        if ($reason) throw new Exception("Failed. " . $reason);

        return true;
    }

    /**
     * Get the assessments that this permission has.
     */
    public function assessments() {
        return $this->hasMany(Assessment::class, "judge_permission_id");
    }

    /**
     * Get the answer type that this permission belongs to.
     */
    public function assessmentComponent() {
        return $this->belongsTo(AssessmentComponent::class);
    }

    /**
     * Get the judge that this permission belongs to.
     */
    public function judge() {
        return $this->belongsTo(Judge::class);
    }

    /**
     * Override default delete method.
     * 
     * @return bool
     */
    public function delete() {
        return self::query()
            ->whereBelongsTo($this->assessmentComponent)
            ->whereBelongsTo($this->judge)
            ->delete();
    }
}
