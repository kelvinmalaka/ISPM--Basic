<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\PeriodType;
use App\Models\RegistrationStatus;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  User     $user
     * @param  Answer   $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Answer $answer) {
        $answer->loadMissing("team.contestant");
        return $answer->team->contestant->user->is($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User     $user
     * @param  Team     $team
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Team $team) {
        $team->loadMissing(["contestant", "contest", "registration", "category"])->loadCount("answers");

        return $team->contestant->user->is($user) &&
            $team->contest->period(PeriodType::SUBMISSION)->isActive() &&
            $team->registration->status->usid === RegistrationStatus::APPROVED &&
            $team->answers_count < $team->category->max_answer_uploads;
    }

    /**
     * Determine whether the user can validate team answer.
     *
     * @param  User     $user
     * @param  Answer   $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function validate(User $user, Answer $answer) {
        $committee = $user->userable(Role::COMMITTEE);
        $team = $answer->team;

        return $team->contest->period(PeriodType::ANSWER_VALIDATION)->isActive() &&
            $team->category->committees()->where("committee_id", $committee->id)->exists();
    }

    /**
     * Determine whether the user can assess the model.
     *
     * @param  User     $user
     * @param  Answer   $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function assess(User $user, Answer $answer) {
        $judge = $user->userable(Role::JUDGE);
        $team = $answer->team;

        return $team->contest->period(PeriodType::ASSESSMENT)->isActive() &&
            $answer->isVerified() &&
            $team->category
            ->assessmentComponents()
            ->whereRelation("judges", "judge_id", $judge->id)
            ->exists();
    }
}
