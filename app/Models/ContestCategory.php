<?php

namespace App\Models;

use App\File\CategoryGuideFile;
use App\File\CategoryCaseFile;
use App\Models\AnswerType;
use App\Models\AssessmentComponent;
use App\Models\Committee;
use App\Models\Contest;
use App\Models\Team;
use App\Models\Traits\GuardDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Exception;

class ContestCategory extends Model {
    use HasFactory, GuardDelete;

    /**
     * Get the contest that owns the contest category.
     */
    public function contest() {
        return $this->belongsTo(Contest::class);
    }

    /**
     * Get the contestant teams that joined the contest category.
     */
    public function teams() {
        return $this->hasMany(Team::class);
    }

    /**
     * Get the committees of the contest category.
     * 
     * @return BelongsToMany
     */
    public function committees(): BelongsToMany {
        return $this->belongsToMany(Committee::class, CommitteePermission::getTableName())
            ->using(CommitteePermission::class)
            ->as("permission");
    }

    /**
     * Get the assessment components of the contest category.
     */
    public function assessmentComponents() {
        return $this->hasMany(AssessmentComponent::class);
    }

    /**
     * Get the answer types of the contest category.
     */
    public function answerTypes() {
        return $this->hasMany(AnswerType::class);
    }

    /**
     * Determine if a contest category can be deleted.
     * 
     * @return  bool
     * @throws  Exception
     */
    public function canBeDeleted(): bool {
        $reason = "";

        $teams = $this->teams->count();
        if ($teams) {
            $reason = "Already have " . $teams . " registered teams";
        }

        if ($reason) throw new Exception("Failed. " . $reason);

        return true;
    }

    /**
     * Return guide file.
     * 
     * @return  CategoryGuideFile
     */
    public function getGuideAttribute(): CategoryGuideFile {
        return new CategoryGuideFile($this);
    }

    /**
     * Return case file.
     * 
     * @return  CategoryCaseFile
     */
    public function getCaseAttribute(): CategoryCaseFile {
        return new CategoryCaseFile($this);
    }
}
