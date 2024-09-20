<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\GuardDelete;
use App\Models\ContestCategory;
use App\Models\AnswerDetail;
use Exception;

class AnswerType extends Model {
    use HasFactory, GuardDelete;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Available file types.
     *
     * @var array
     */
    public const VAILD_FILE_TYPES = ["pdf", "zip", "rar"];

    /**
     * Determine if an answer type can be deleted.
     * 
     * @return bool
     * @throws  Exception
     */
    public function canBeDeleted() {
        $reason = "";

        $submissions = $this->answerDetails->count();
        if ($submissions) {
            $reason = "Already have " . $submissions . " submissions using this answer type.";
        }

        if ($reason) throw new Exception("Failed. " . $reason);

        return true;
    }

    /**
     * Get the contest category that owns the answer type.
     */
    public function contestCategory() {
        return $this->belongsTo(ContestCategory::class);
    }

    /**
     * Get the contestant team answers that has this answer type.
     */
    public function answerDetails() {
        return $this->hasMany(AnswerDetail::class);
    }
}
