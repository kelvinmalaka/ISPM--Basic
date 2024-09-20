<?php

namespace App\Models;

use App\Models\RegistrationStatus;
use App\Models\Team;
use App\Models\Committee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model {
    use HasFactory;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['status'];

    /**
     * Get the registration status of the validation.
     * 
     * @return BelongsTo
     */
    public function status(): BelongsTo {
        return $this->belongsTo(RegistrationStatus::class, "registration_status_id");
    }

    /**
     * Get the team of the validation.
     * 
     * @return BelongsTo
     */
    public function team(): BelongsTo {
        return $this->belongsTo(Team::class);
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
