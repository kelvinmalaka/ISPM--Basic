<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasPublishedState {
  /**
   * Determine the entity published state.
   *
   * @return  bool
   */
  abstract public function isPublished(): bool;

  /**
   * Scope entity based on published state.
   * 
   * @param  Builder $builder
   * @param  bool    $published
   * @return void
   */
  abstract public function scopePublished(Builder $builder, bool $published): void;

  /**
   * Change the entity published state to true.
   *
   * @return  bool
   */
  abstract public function publish(): bool;

  /**
   * Change the entity publish state to false.
   *
   * @return  bool
   */
  abstract public function unpublish(): bool;
}
