<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Team;
use App\Models\Assessment;
use App\Models\AnswerValidation;
use App\Models\AnswerDetail;
use App\File\AnswerFile;
use Kirschbaum\PowerJoins\PowerJoins;

class Answer extends Model {
    use HasFactory, PowerJoins;

    /**
     * Get the assessments of the answer.
     * 
     * @param  Assessment   $assessment
     * @return void
     */
    public function setAssessmentAttribute($assessment) {
        $this->attributes["assessment"] = $assessment;
    }

    /**
     * Get the team that owns the answer.
     */
    public function team() {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the assessments of the answer.
     */
    public function assessments() {
        return $this->hasMany(Assessment::class);
    }

    /**
     * Get the validations of this answer.
     */
    public function validation() {
        return $this->hasOne(AnswerValidation::class);
    }

    /**
     * Determine if the answer is verified.
     * 
     * @return bool
     */
    public function isVerified(): bool {
        $validation = $this->validation;
        return $validation && $validation->status->usid === AnswerStatus::APPROVED;
    }

    /**
     * Get the details of this answer.
     */
    public function details() {
        return $this->hasMany(AnswerDetail::class);
    }

    /**
     * Get the assessment of the answer by specific judge.
     * 
     * @param  Builder  $query
     * @param  int  $judgeId
     * @return Builder
     */
    public function scopeWithJudgeAssessment(Builder $query, int $judgeId) {
        return $query->with(
            [
                'assessments' => function ($query) use ($judgeId) {
                    $query->whereHas('judge', fn ($query) => $query->where('judge_id', '=', $judgeId));
                }
            ]
        );
    }

    /**
     * Return answer file.
     * 
     * @return  AnswerFile
     */
    public function getFileAttribute(): AnswerFile {
        return new AnswerFile($this);
    }
}
