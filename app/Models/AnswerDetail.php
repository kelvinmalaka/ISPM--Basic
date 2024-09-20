<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;
use App\Models\AnswerType;

class AnswerDetail extends Model {
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get the answer that this detail belongs to.
     */
    public function answer() {
        return $this->belongsTo(Answer::class);
    }

    /**
     * Get the answer type that this detail belongs to.
     */
    public function type() {
        return $this->belongsTo(AnswerType::class, "answer_type_id");
    }
}
