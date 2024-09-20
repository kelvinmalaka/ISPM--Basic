<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamMemberPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  User     $user
     * @param  Team     $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Team $team) {
        $team->loadMissing("category")->loadCount("members");

        return $user->can('update', $team) &&
            $team->members_count < $team->category->max_team_member;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User         $user
     * @param  TeamMember   $member
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TeamMember $member) {
        $member->loadMissing("team");

        return $user->can('update', $member->team);
    }
}
