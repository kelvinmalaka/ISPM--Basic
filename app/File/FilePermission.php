<?php

namespace App\File;

use App\Models\User;
use Illuminate\Support\Facades\File;

abstract class FilePermission {
  /**
   * Path of the file.
   *
   * @var string|null 
   */
  protected string $path = "";

  /**
   * Class constructor.
   *
   * @param   $path Path relative to storage directory
   * @return  void 
   */
  public function __construct(string $path = null) {
    if ($path) $this->path = storage_path('app/' . $path);
  }

  /**
   * Determine if the file is exist in directory.
   *
   * @return  bool 
   */
  public function exists(): bool {
    return isset($this->path) && File::exists($this->path);
  }

  /**
   * Get the path of file.
   *
   * @return  string
   */
  public function getPath(): string {
    return $this->path;
  }

  /**
   * Determine if the file can be accessed by user.
   *
   * @param   User  $user
   * @return  bool
   */
  abstract public function canBeAccessedBy(User $user): bool;
}
