<?php

namespace App\View;

use App\Http\Controllers\ContestController;
use App\Http\Controllers\Contest\ContestManagementController;
use App\Http\Controllers\User\UserManagementController;
use App\Http\Controllers\Validate\RegistrationController;
use App\Http\Controllers\Validate\AnswerController;
use App\Http\Controllers\Assessment\AssessmentController;
use App\Models\Role;

class RoleRoutes {
  /**
   * Return routes for role.
   *
   * @param  string   $role
   * @return array
   */
  public static function getRoute($role): array {
    switch ($role) {
      case Role::SUPERADMIN:
        return self::superadmin();

      case Role::ADMIN:
        return self::administrator();

      case Role::COMMITTEE:
        return self::committee();

      case Role::JUDGE:
        return self::judge();

      case Role::CONTESTANT:
        return self::contestant();

      default:
        return self::guest();
    }
  }

  /**
   * Return routes for public or guest.
   *
   * @return array
   */
  private static function guest(): array {
    return [
      [
        'name' => 'home',
        'hash' => '#home',
        'title' => 'Home'
      ],
      [
        'name' => 'home',
        'hash' => '#about',
        'title' => 'About Us'
      ],
      [
        'name' => 'home',
        'hash' => '#events',
        'title' => 'Events'
      ],
      [
        'name' => 'home',
        'hash' => '#partners',
        'title' => 'Partners'
      ],
    ];
  }

  /**
   * Return routes for superadmin role.
   *
   * @return array
   */
  private static function superadmin(): array {
    return [
      [
        'name' => 'home',
        'title' => 'Homepage',
        'icon' => 'house-fill'
      ],
      [
        'name' => ContestManagementController::routeNames . '.index',
        'title' => 'Manage Contests',
        'icon' => 'flower1'
      ],
      [
        'name' => UserManagementController::routeNames . '.index',
        'title' => 'Manage Users',
        'icon' => 'people-fill'
      ],
    ];
  }

  /**
   * Return routes for administrator role.
   *
   * @return array
   */
  private static function administrator(): array {
    return [
      [
        'name' => 'home',
        'title' => 'Homepage',
        'icon' => 'house-fill'
      ],
      [
        'name' => ContestManagementController::routeNames . '.index',
        'title' => 'Manage Contests',
        'icon' => 'flower1',
      ],
    ];
  }

  /**
   * Return routes for committee role.
   *
   * @return array
   */
  private static function committee(): array {
    return [
      [
        'name' => 'home',
        'title' => 'Homepage',
        'icon' => 'house-fill'
      ],
      [
        'name' => RegistrationController::routeNames . '.index',
        'title' => 'Validate Registrations',
        'icon' => 'file-earmark-ruled'
      ],
      [
        'name' => AnswerController::routeNames . '.index',
        'title' => 'Validate Answers',
        'icon' => 'file-earmark-ruled'
      ],
    ];
  }

  /**
   * Return routes for judge role.
   *
   * @return array
   */
  private static function judge(): array {
    return [
      [
        'name' => 'home',
        'title' => 'Homepage',
        'icon' => 'house-fill'
      ],
      [
        'name' => AssessmentController::routeNames . '.index',
        'title' => 'Assessments',
        'icon' => 'file-earmark-spreadsheet'
      ]
    ];
  }

  /**
   * Return routes for contestant role.
   *
   * @return array
   */
  private static function contestant(): array {
    return [
      [
        'name' => 'home',
        'title' => 'Homepage',
        'icon' => 'house-fill'
      ],
      [
        'name' => ContestController::routeNames . '.index',
        'title' => 'Contests',
        'icon' => 'flower1'
      ]
    ];
  }
}
