<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\AnswerType;
use App\Models\AssessmentComponent;
use App\Models\CommitteePermission;
use App\Models\Contest;
use App\Models\ContestCategory;
use App\Models\JudgePermission;
use App\Models\Team;
use App\Models\TeamMember;
use App\Policies\AnswerPolicy;
use App\Policies\AnswerTypePolicy;
use App\Policies\AssessmentComponentPolicy;
use App\Policies\CommitteePermissionPolicy;
use App\Policies\ContestCategoryPolicy;
use App\Policies\ContestPolicy;
use App\Policies\JudgePermissionPolicy;
use App\Policies\TeamMemberPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Contest::class => ContestPolicy::class,
        ContestCategory::class => ContestCategoryPolicy::class,
        CommitteePermission::class => CommitteePermissionPolicy::class,
        AnswerType::class => AnswerTypePolicy::class,
        AssessmentComponent::class => AssessmentComponentPolicy::class,
        JudgePermission::class => JudgePermissionPolicy::class,
        Team::class => TeamPolicy::class,
        TeamMember::class => TeamMemberPolicy::class,
        Answer::class => AnswerPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();
    }
}
