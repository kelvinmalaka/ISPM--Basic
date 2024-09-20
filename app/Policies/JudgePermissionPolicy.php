<?php

namespace App\Policies;

use App\Models\AssessmentComponent;
use App\Models\JudgePermission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JudgePermissionPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  User                 $user
     * @param  AssessmentComponent  $component
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, AssessmentComponent $component) {
        if ($user->role === Role::SUPERADMIN) return true;

        if ($user->role === Role::ADMIN) {
            return $component->contestCategory->contest->administrator->user->is($user);
        }

        return false;
    }

    /**
     * Determine whether the user can manage the model.
     *
     * @param  User             $user
     * @param  JudgePermission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function manage(User $user, JudgePermission $permission) {
        if ($user->role === Role::SUPERADMIN) return true;

        if ($user->role === Role::ADMIN) {
            return $permission->assessmentComponent->category->contest->administrator->user->is($user);
        }

        return false;
    }
}
