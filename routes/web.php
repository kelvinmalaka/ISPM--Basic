<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginMicrosoftController;
use App\Http\Controllers\Auth\RoleSwitchController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContestController;

use App\Http\Controllers\User\UserManagementController;
use App\Http\Controllers\User\RoleManagementController;

use App\Http\Controllers\Contest\ContestManagementController;
use App\Http\Controllers\Contest\PeriodManagementController;
use App\Http\Controllers\Contest\CategoryManagementController;
use App\Http\Controllers\Contest\CommitteePermissionManagementController;
use App\Http\Controllers\Contest\AnswerTypeManagementController;
use App\Http\Controllers\Contest\AssessmentComponentManagementController;
use App\Http\Controllers\Contest\JudgePermissionManagementController;
use App\Http\Controllers\Contest\TeamManagementController;

use App\Http\Controllers\Contestant\TeamController;
use App\Http\Controllers\Contestant\TeamMemberController;
use App\Http\Controllers\Contestant\AnswerController;
use App\Http\Controllers\Contestant\ScoreController;

use App\Http\Controllers\Validate\RegistrationController;
use App\Http\Controllers\Validate\AnswerController as AnswerValidationController;
use App\Http\Controllers\Assessment\AssessmentController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
| Generate route for unauthorized users
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('contests', ContestController::class)->only(["index", "show"])->names(ContestController::routeNames);

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
| Generate routes needed for authentication.
*/

Auth::routes(["verify" => true]);
Route::get('/ms-login', [LoginMicrosoftController::class, 'login'])->name('ms-login');
Route::get('/ms-callback', [LoginMicrosoftController::class, 'callback'])->name('ms-login-callback');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
| Generate routes needed for application.
| These routes are accessible according to user role,
| which stated in each controllers.
*/

/*
- General routes to determine which page to be accessed by authenticated user based on its role.
*/
Route::get('/application', [HomeController::class, 'application'])->name('application');

Route::prefix('manage')->group(function () {
    Route::middleware('roles:' . Role::SUPERADMIN)->group(function () {
        Route::resource('users', UserManagementController::class)->only(["index", "create", "store", "show", "destroy"])->names(UserManagementController::routeNames);
        Route::resource('users.roles', RoleManagementController::class)->only(["create", "store"])->names(RoleManagementController::routeNames);
    });

    Route::middleware('roles:' . Role::SUPERADMIN . ',' . Role::ADMIN)->group(function () {
        Route::resource('contests', ContestManagementController::class)->names(ContestManagementController::routeNames);
        Route::get('contests/{contest}/report', [ContestManagementController::class, 'report'])->name(ContestManagementController::routeNames . ".report");
        Route::resource('contests.periods', PeriodManagementController::class)->only(["index", "store"])->names(PeriodManagementController::routeNames);
        Route::resource('contests.categories', CategoryManagementController::class)->except(["index"])->names(CategoryManagementController::routeNames)->shallow();
        Route::resource('contests.categories.committees', CommitteePermissionManagementController::class)->only(["create", "store", "destroy"])->names(CommitteePermissionManagementController::routeNames)->shallow();
        Route::resource('contests.categories.answers', AnswerTypeManagementController::class)->except(["index", "show"])->names(AnswerTypeManagementController::routeNames)->shallow();
        Route::resource('contests.categories.assessments', AssessmentComponentManagementController::class)->except(["index"])->names(AssessmentComponentManagementController::routeNames)->shallow();
        Route::resource('contests.categories.assessments.judges', JudgePermissionManagementController::class)->only(["create", "store", "destroy"])->names(JudgePermissionManagementController::routeNames)->shallow();
        Route::resource('contests.teams', TeamManagementController::class)->only(["show"])->names(TeamManagementController::routeNames)->shallow();
    });
});

Route::middleware(["roles:" . Role::CONTESTANT, "verified"])->group(function () {
    Route::resource('contests.teams', TeamController::class)->only(["show", "create", "store", "edit", "update"])->names(TeamController::routeNames)->shallow();
    Route::post('teams/{team}/register', [TeamController::class, 'register'])->name(TeamController::routeNames . ".register");
    Route::resource('contests.teams.members', TeamMemberController::class)->only(["show", "create", "store", "edit", "update", "destroy"])->names(TeamMemberController::routeNames)->shallow();
    Route::resource('contests.answers', AnswerController::class)->only(["index", "create", "store"])->names(AnswerController::routeNames)->shallow();
    Route::resource('contests.score', ScoreController::class)->only(["index"])->names(ScoreController::routeNames);
});

Route::prefix('validate')->middleware("roles:committee")->group(function () {
    Route::resource('registrations', RegistrationController::class)->only(["index", "edit", "store"])->names(RegistrationController::routeNames);
    Route::resource('answers', AnswerValidationController::class)->only(["index", "edit", "store"])->names(AnswerValidationController::routeNames);
});

Route::prefix('assessment')->middleware("roles:judge")->group(function () {
    Route::resource("answers", AssessmentController::class)->only(["index", "edit", "update"])->names(AssessmentController::routeNames);
});

Route::middleware("auth")->group(function () {
    Route::get("profile", [ProfileController::class, 'index'])->name(ProfileController::routeNames . ".index");
    Route::put("profile", [ProfileController::class, 'update'])->name(ProfileController::routeNames . ".update");
    Route::get('switch-role', [RoleSwitchController::class, 'index'])->name(RoleSwitchController::routeNames . ".index");
    Route::get('switch-role/{role}', [RoleSwitchController::class, 'store'])->name(RoleSwitchController::routeNames . ".store");
});

Route::prefix('file')->group(function () {
    Route::get("contest/{contest}", [FileController::class, 'contestGuide'])->name(FileController::routeNames . ".contest");
    Route::get("category/{category}", [FileController::class, 'categoryGuide'])->name(FileController::routeNames . ".category");
    Route::get("case/{case}", [FileController::class, 'categoryCase'])->name(FileController::routeNames . ".case");
    Route::get("team/{team}", [FileController::class, 'team'])->name(FileController::routeNames . ".team");
    Route::get("answer/{answer}", [FileController::class, 'answer'])->name(FileController::routeNames . ".answer");
});
