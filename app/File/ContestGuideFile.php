<?php

namespace App\File;

use App\File\FilePermission;
use App\Models\User;

class ContestGuideFile extends FilePermission {
  /**
   * Determine if the file can be accessed by user.
   *
   * @param   User  $user
   * @return  bool
   */
  public function canBeAccessedBy(User $user): bool {
    return true;
  }
}
