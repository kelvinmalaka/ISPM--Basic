<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use App\Models\Contestant;
use App\Models\TeamMember;
use App\Models\Answer;
use App\Models\ContestCategory;
use App\Models\Registration;
use App\File\TeamFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Team extends Model {
    use HasFactory, PowerJoins;

    /**
     * Get the contestant that owns the team.
     * 
     * @return BelongsTo
     */
    public function contestant(): BelongsTo {
        return $this->belongsTo(Contestant::class);
    }

    /**
     * Get the contest category that the team joined.
     * 
     * @return BelongsTo
     */
    public function contestCategory(): BelongsTo {
        return $this->belongsTo(ContestCategory::class);
    }

    /**
     * Get the contest category that the team joined.
     * 
     * @return BelongsTo
     */
    public function category(): BelongsTo {
        return $this->belongsTo(ContestCategory::class, "contest_category_id");
    }

    /**
     * Set relationship of the contest that the team joined.
     * 
     * @return HasOneThrough
     */
    public function contest(): HasOneThrough {
        return $this->hasOneThrough(Contest::class, ContestCategory::class, 'id', 'id', 'contest_category_id', 'contest_id');
    }

    /**
     * Get the members of contestant team.
     */
    public function members() {
        return $this->hasMany(TeamMember::class);
    }

    /**
     * Determine if this team has a leader
     * 
     * @return bool
     */
    public function hasLeader(): bool {
        return $this->members()->where("is_leader", true)->limit(1)->exists();
    }

    /**
     * Get the all answers of contestant team.
     */
    public function answers() {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the latest answer of team.
     */
    public function answer() {
        return $this->hasOne(Answer::class)->latestOfMany('created_at');
    }

    /**
     * Get the verified answer of contestant team.
     */
    public function verifiedAnswer() {
        return $this->hasOne(Answer::class)
            ->ofMany([
                "id" => "max",
                "created_at" => "max"
            ], function ($query) {
                return $query->whereRelation("validation.status", "usid", AnswerStatus::APPROVED);
            });
    }

    /**
     * Determine if team has verified answer.
     * 
     * @return bool
     */
    public function hasVerifiedAnswer(): bool {
        return $this->verifiedAnswer()->exists();
    }

    /**
     * Scoping team that needs answer validation.
     * 
     * @return void
     */
    public function scopeNeedAnswerValidation(Builder $query): void {
        $query->whereHas("answer", function (Builder $query) {
            $query->whereDoesntHave("validation");
        });
    }

    /**
     * Update team leader changes.
     * 
     * @return bool
     */
    public function updateLeader(TeamMember $member) {
        $members = [$member];

        $currentLeader = $this->members()->where('is_leader', true)->first();
        if ($currentLeader) {
            $currentLeader->is_leader = false;
            $members[] = $currentLeader;
        }

        $member->is_leader = true;
        $this->members()->saveMany($members);
    }

    /**
     * Get the registration validation logs of this team.
     */
    public function registrations() {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get the latest registration status of this team.
     */
    public function registration() {
        return $this->hasOne(Registration::class)->latestOfMany();
    }

    /**
     * Scoping team that needs registration validation.
     */
    public function scopeNeedRegistrationValidation(Builder $query) {
        $query->whereRelation("registration.status", function (Builder $query) {
            $query->whereIn("usid", [
                RegistrationStatus::SUBMITTED,
                RegistrationStatus::REVISED
            ]);
        });
    }

    /**
     * Determine if the registration is verified.
     * 
     * @return bool
     */
    public function isRegistrationVerified(): bool {
        return $this->registration->status->usid === RegistrationStatus::APPROVED;
    }

    /**
     * Calculate team overall score.
     * 
     * @return float
     */
    private function getOverallScore(): float {
        $answer = $this->verifiedAnswer;
        $this->load(["category.assessmentComponents.assessments" => fn($query) => $query->whereBelongsTo($answer)]);

        $scores = $this->category->assessmentComponents
            ->map(function (AssessmentComponent $component) {
                $component->loadCount("judges");

                $sumScore = $component->assessments->sum('score');
                $judgesCount = $component->judges_count;

                $averageScore = $sumScore / $judgesCount;
                return $averageScore * $component->weight / 100;
            });

        return $scores->sum();
    }

    /**
     * Update team's overall score.
     * 
     * @return bool
     */
    public function updateOverallScore(): bool {
        $this->overall_score = $this->getOverallScore();
        return $this->save();
    }


    /**
     * Return team registration document.
     * 
     * @return  TeamFile
     */
    public function getDocumentAttribute(): TeamFile {
        return new TeamFile($this);
    }
}
