<?php

namespace App\Policies;

use App\Models\Contest;
use App\Models\PeriodType;
use App\Models\RegistrationStatus;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  User     $user
     * @param  Team     $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Team $team) {
        $team->loadMissing("contestant");
        return $team->contestant->user->is($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User     $user
     * @param  Contest  $contest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Contest $contest) {
        return $user->role === Role::CONTESTANT &&
            $contest->period(PeriodType::REGISTRATION)->isActive() &&
            !$contest->getContestantTeam();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User     $user
     * @param  Team     $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Team $team) {
        $team->loadMissing(["contest", "contestant", "registration"]);

        return $team->contestant->user->is($user) &&
            $team->contest->period(PeriodType::REGISTRATION)->isActive() &&
            ($team->registration->status->usid === RegistrationStatus::CREATED || $team->registration->status->usid === RegistrationStatus::REJECTED);
    }

    /**
     * Determine whether the user can register their team.
     *
     * @param  User     $user
     * @param  Team     $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function register(User $user, Team $team) {
        $team->loadMissing(["category", "contest", "contestant", "registration"])->loadCount("members");

        return $team->contestant->user->is($user) &&
            $team->contest->period(PeriodType::REGISTRATION)->isActive() &&
            ($team->registration->status->usid === RegistrationStatus::CREATED || $team->registration->status->usid === RegistrationStatus::REJECTED) &&
            $team->members_count &&
            $team->hasLeader() &&
            $team->members_count <= $team->category->max_team_member;
    }

    /**
     * Determine whether the user can validate team registration.
     *
     * @param  User     $user
     * @param  Team     $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function validate(User $user, Team $team) {
        $committee = $user->userable(Role::COMMITTEE);
        return $team->category->committees()->where("committee_id", $committee->id)->exists();
    }

    /**
     * Determine whether the team can access specific pages.
     *
     * @param  User     $user
     * @param  Team     $team
     * @param  string   $page
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function access(User $user, Team $team, string $page) {
        $contest = $team->contest;

        $team->loadMissing("registration");
        $contest->loadMissing("periods");

        switch ($page) {
            case "answer":
                return $contest->period(PeriodType::SUBMISSION)->hasPassedOpeningDate() &&
                    $team->isRegistrationVerified();

            case "score":
                $team->loadExists("verifiedAnswer");
                return $contest->period(PeriodType::ANNOUNCEMENT)->hasPassedOpeningDate() &&
                    $team->isRegistrationVerified() &&
                    $team->hasVerifiedAnswer();

            default:
                return false;
        }
    }
}
