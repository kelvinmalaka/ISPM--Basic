<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\Contest;
use App\Models\PeriodType;
use Kirschbaum\PowerJoins\PowerJoins;

class Period extends Model {
    use HasFactory, PowerJoins;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['type'];

    /**
     * Get the contest that owns the period.
     */
    public function contest() {
        return $this->belongsTo(Contest::class);
    }

    /**
     * Get the period type of the contest period.
     */
    public function type() {
        return $this->belongsTo(PeriodType::class, "period_type_id");
    }

    /**
     * Checks if this period is currently active.
     * 
     * @return bool
     */
    public function isActive(): bool {
        return Carbon::now()->between($this->opened_at, $this->closed_at);
    }

    /**
     * Checks if this period has passed opening date.
     * 
     * @return bool
     */
    public function hasPassedOpeningDate(): bool {
        return Carbon::now()->gte($this->opened_at);
    }
}
