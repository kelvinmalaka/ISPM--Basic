<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\File\ContestGuideFile;
use App\Models\Administrator;
use App\Models\ContestCategory;
use App\Models\Period;
use App\Models\Team;
use App\Models\Traits\GuardDelete;
use App\Models\Traits\HasPublishedState;
use Exception;

class Contest extends Model {
    use HasFactory, GuardDelete, HasPublishedState;

    /**
     * Scope published contests.
     * 
     * @param  Builder $builder
     * @return void
     */
    public function scopePublished(Builder $builder, bool $published = true): void {
        $operator = $published ? "!=" : "=";
        $builder->where("published_at", $operator, null);
    }

    /**
     * Scope contests with active period
     * 
     * @param  Builder  $builder
     * @param  string   $usid       Period type.
     * @return void
     */
    public function scopePeriodActive(Builder $builder, string $usid): void {
        $builder->whereRelation("periods", function (Builder $builder) use ($usid) {
            $builder->whereRelation("type", "usid", "=", $usid)
                ->whereDate("opened_at", "<=", now())
                ->whereDate("closed_at", ">=", now());
        });
    }

    /**
     * Get the categories of the contest.
     */
    public function categories() {
        return $this->hasMany(ContestCategory::class);
    }

    /**
     * Get the periods of the contest.
     */
    public function periods() {
        return $this->hasMany(Period::class);
    }

    /**
     * Get the period of the contest.
     * 
     * @param  string  $usid
     * @return Period
     */
    public function period(string $usid): Period {
        $this->loadMissing("periods");
        return $this->periods->where('type.usid', $usid)->first();
    }

    /**
     * Get the the teams joined the contest.
     */
    public function teams() {
        return $this->hasManyThrough(Team::class, ContestCategory::class);
    }

    /**
     * Get the the team that belongs to current user as contestant.
     * 
     * @return Team|null
     */
    public function getContestantTeam() {
        if (auth()->check() && auth()->user()->role === Role::CONTESTANT) {
            $contestant = auth()->user()->userable(Role::CONTESTANT);
            return $this->teams()->whereBelongsTo($contestant)->first();
        }

        return null;
    }

    /**
     * Get the administrator of the contest.
     */
    public function administrator() {
        return $this->belongsTo(Administrator::class);
    }

    /**
     * Determine if contest is published.
     * 
     * @return bool
     */
    public function isPublished(): bool {
        return $this->published_at !== null;
    }

    /**
     * Set contest state to published.
     * 
     * @return bool
     */
    public function publish(): bool {
        if ($this->isPublished()) return true;

        $this->published_at = now();
        return $this->save();
    }

    /**
     * Set contest state to unpublished.
     * 
     * @return bool
     */
    public function unpublish(): bool {
        if (!$this->isPublished()) return true;

        $this->published_at = null;
        return $this->save();
    }

    /**
     * Determine if a contest can be deleted.
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
     * @return  ContestGuideFile
     */
    public function getGuideAttribute(): ContestGuideFile {
        return new ContestGuideFile($this->guide_file_path);
    }
}
