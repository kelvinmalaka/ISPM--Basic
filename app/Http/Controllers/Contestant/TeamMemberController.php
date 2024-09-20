<?php

namespace App\Http\Controllers\Contestant;

use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Contestant\TeamController;
use App\Http\Requests\Contestant\StoreTeamMemberRequest;
use App\Http\Requests\Contestant\UpdateTeamMemberRequest;
use App\Models\Contest;
use App\Models\Team;
use App\Models\TeamMember;

class TeamMemberController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contestant_team_member";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contestant.team_member";

    /**
     * Show the form for creating a new resource.
     *
     * @param  Contest  $contest
     * @param  Team     $team
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Contest $contest, Team $team) {
        $this->authorize("create", [TeamMember::class, $team]);

        $member = new TeamMember();
        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store", ["contest" => $contest, "team" => $team]))
            ->with("method", "POST")
            ->with("member", $member);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTeamMemberRequest   $request
     * @param  Contest  $contest
     * @param  Team     $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTeamMemberRequest $request, Contest $contest, Team $team) {
        $this->authorize("create", [TeamMember::class, $team]);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $national_id_file_path = $request->file("national_id_file")->store("contestants");
        $student_id_file_path = $request->file("student_id_file")->store("contestants");

        $member = new TeamMember();

        $member->name = $data["name"];
        $member->email = $data["email"];
        $member->phone = $data["phone"];
        $member->national_id = $data["national_id"];
        $member->student_id = $data["student_id"];
        $member->national_id_file_path = $national_id_file_path;
        $member->student_id_file_path = $student_id_file_path;

        $member->team()->associate($team);
        $member->save();

        if (array_key_exists("is_leader", $data) && boolval($data["is_leader"])) {
            $team->updateLeader($member);
        }

        return redirect()
            ->to($previousURL)
            ->with("message", "New member added!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TeamMember   $member
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(TeamMember $member) {
        $this->authorize("update", $member);

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".update", ["member" => $member]))
            ->with("method", "PUT")
            ->with("member", $member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTeamMemberRequest  $request
     * @param  TeamMember   $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTeamMemberRequest $request, TeamMember $member) {
        $this->authorize("update", $member);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $member->name = $data["name"];
        $member->email = $data["email"];
        $member->phone = $data["phone"];
        $member->national_id = $data["national_id"];
        $member->student_id = $data["student_id"];

        if ($request->hasFile("national_id_file")) {
            $national_id_file_path = $request->file("national_id_file")->store("contestants");
            $member->national_id_file_path = $national_id_file_path;
        }

        if ($request->hasFile("student_id_file")) {
            $student_id_file_path = $request->file("student_id_file")->store("contestants");
            $member->student_id_file_path = $student_id_file_path;
        }

        if (array_key_exists("is_leader", $data) && boolval($data["is_leader"])) {
            $member->team->updateLeader($member);
        }

        $member->save();

        return redirect()
            ->to($previousURL)
            ->with("message", "Updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TeamMember   $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamMember $member) {
        $team = $member->team;

        $member->delete();

        return redirect()
            ->route(TeamController::routeNames . ".show", ["team" => $team])
            ->with("message", "Deleted!");
    }
}
