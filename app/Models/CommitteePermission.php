<?php

namespace App\Models;

use App\Models\ContestCategory;
use App\Models\Committee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CommitteePermission extends Pivot {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "committee_permissions";

    /**
     * Get table name of the model.
     *
     * @return string
     */
    public static function getTableName(): string {
        return "committee_permissions";
    }

    /**
     * Override primary key attribute using composite key
     * 
     * @return string
     */
    public function getKey(): string {
        return $this->category->id . "_" . $this->committee->id;
    }

    /**
     * Get the contest category that this permission belongs to.
     * 
     * @return BelongsTo
     */
    public function category(): BelongsTo {
        return $this->belongsTo(ContestCategory::class, "contest_category_id");
    }

    /**
     * Get the committee that this permission belongs to.
     * 
     * @return BelongsTo
     */
    public function committee(): BelongsTo {
        return $this->belongsTo(Committee::class);
    }

    /**
     * Override default delete method.
     * 
     * @return bool
     */
    public function delete() {
        return self::query()
            ->whereBelongsTo($this->category, "category")
            ->whereBelongsTo($this->committee)
            ->delete();
    }
}
