<?php

namespace App\File;

use App\File\FilePermission;
use App\Models\User;
use App\Models\ContestCategory;

class CategoryGuideFile extends FilePermission {
  /**
   * Store contest category.
   *
   * @var ContestCategory 
   */
  protected ContestCategory $category;

  /**
   * Class constructor.
   *
   * @param   int  $id
   * @return  void
   */
  public function __construct(ContestCategory $category) {
    $this->category = $category;
    parent::__construct($category->guide_file_path);
  }

  /**
   * Determine if the file can be accessed by user.
   *
   * @param   User  $user
   * @return  bool
   */
  public function canBeAccessedBy(User $user): bool {
    if ($user->role === "superadmin") return true;

    if ($user->role === "administrator") {
      $contest = $this->category->contest()->with("administrator.user")->first();
      return $contest->administrator->user->is($user);
    }

    if ($user->role === "committee") {
      $committees = $this->category->committees()->with("user")->get();
      $committee = $committees->map(fn ($committee) => $committee->user)->first(fn ($committee) => $committee->is($user));

      return boolval($committee);
    }

    if ($user->role === "judge") {
      $components = $this->category->assessmentComponents()->with("judges.user")->get();
      $judges = $components->map(fn ($component) => $component->judges)->flatten();
      $judge = $judges->map(fn ($judge) => $judge->user)->first(fn ($judge) => $judge->is($user));

      return boolval($judge);
    }

    if ($user->role === "contestant") {
      $teams = $this->category->teams()->with("contestant.user")->get();
      $contestant = $teams->map(fn ($team) => $team->contestant->user)->first(fn ($contestant) => $contestant->is($user));

      return boolval($contestant);
    }

    return false;
  }
}
