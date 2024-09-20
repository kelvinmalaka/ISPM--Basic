<?php

namespace App\Models\Traits;

trait GuardDelete {
  /**
   * Determine the entity is safe to be deleted.
   *
   * @return  bool
   * @throws  \Exception
   */
  abstract public function canBeDeleted(): bool;

  /**
   * Delete the entity.
   *
   * @return  bool
   * @throws  \Exception
   */
  public function delete(): bool {
    if ($this->canBeDeleted()) {
      $status = parent::delete();

      if (!$status) throw new \Exception("Unexpected error when deleting entity.");
      return $status;
    }
  }
}
