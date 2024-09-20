<?php

namespace App\Policies;

use App\Models\Contest;
use App\Models\ContestCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContestCategoryPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  User     $user
     * @param  Contest  $contest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Contest $contest) {
        if ($user->role === Role::SUPERADMIN) return true;

        if ($user->role === Role::ADMIN) {
            return $contest->administrator->user->is($user);
        }

        return false;
    }

    /**
     * Determine whether the user can manage the model.
     *
     * @param  User     $user
     * @param  ContestCategory  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function manage(User $user, ContestCategory $category) {
        if ($user->role === Role::SUPERADMIN) return true;

        if ($user->role === Role::ADMIN) {
            return $category->contest->administrator->user->is($user);
        }

        return false;
    }
}
