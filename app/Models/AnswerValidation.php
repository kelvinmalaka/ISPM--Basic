<?php

namespace App\Models;

use App\Models\Answer;
use App\Models\AnswerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnswerValidation extends Model {
    use HasFactory;

    /**
     * Get the answer status of the validation.
     * 
     * @return BelongsTo
     */
    public function status(): BelongsTo {
        return $this->belongsTo(AnswerStatus::class, "answer_status_id");
    }

    /**
     * Get the team answer of the validation.
     * 
     * @return BelongsTo
     */
    public function answer(): BelongsTo {
        return $this->belongsTo(Answer::class);
    }

    /**
     * Get the committee of the validation.
     * 
     * @return BelongsTo
     */
    public function committee(): BelongsTo {
        return $this->belongsTo(Committee::class);
    }
}
