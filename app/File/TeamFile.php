<?php

namespace App\File;

use App\File\FilePermission;
use App\Models\User;
use App\Models\Team;
use App\Models\ContestCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class TeamFile extends FilePermission {
  /**
   * Store team.
   *
   * @var Team 
   */
  protected Team $team;

  /**
   * Store contest category.
   *
   * @var ContestCategory 
   */
  protected ContestCategory $category;

  /**
   * Store file metadata.
   *
   * @var string
   */
  protected string $metadata = "TEAM REGISTRATION DATA";

  /**
   * Class constructor.
   *
   * @param   int  $id
   * @return  void
   */
  public function __construct(Team $team) {
    $this->team = $team;
    $this->category = $team->contestCategory;
  }

  /**
   * Get the path of file.
   *
   * @return  string
   */
  public function getPath(): string {
    if (!$this->path) $this->path = $this->constructPath();
    return $this->path;
  }

  /**
   * Add line to file metadata.
   *
   * @return  string
   */
  protected function addInformation(string $title = "", string $data = ""): string {
    $this->metadata .= "\n" . $title . ($title ? ": " : "") . $data;
    return $this->metadata;
  }

  /**
   * Construct answer file path.
   *
   * @return  string
   */
  protected function constructPath(): string {
    $team = $this->team;
    $members = $team->members;

    $tempPath = storage_path('app/temp/');
    if (!File::isDirectory($tempPath)) {
      File::makeDirectory($tempPath, 0777, true, true);
    }

    $zip = new ZipArchive();
    $fileName = "Team Registration " . $team->id . "-" . $team->name . ".zip";
    $filePath = $tempPath . $fileName;

    $zip->open($filePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    $this->addInformation("Generated at", Carbon::toLocale(now()));
    $this->addInformation("Team ID", $team->id);
    $this->addInformation("Team Name", $team->name);
    $this->addInformation("Team University", $team->university);
    $this->addInformation("Contest", $team->contest->title);
    $this->addInformation("Contest Category", $team->category->title);
    $this->addInformation();

    foreach ($members as $index => $member) {
      $id = $index + 1;
      $this->addInformation("Member " . $id . " ID", $member->id);
      $this->addInformation("Member " . $id . " Name", $member->name);
      $this->addInformation("Member " . $id . " Email", $member->email);
      $this->addInformation("Member " . $id . " Phone", $member->phone);
      $this->addInformation("Member " . $id . " Role", $member->is_leader ? "Leader" : "Member");
      $this->addInformation("Member " . $id . " National ID", $member->national_id);
      $this->addInformation("Member " . $id . " Student ID", $member->student_id);
      $this->addInformation();

      $fields = ["national_id", "student_id"];

      foreach ($fields as $field) {
        $column =  $member->{$field . "_file_path"};
        $col = explode(".", $column);
        $extension = $col[count($col) - 1];

        $path = storage_path('app/' . $column);
        $filename = basename($path);

        $zip->addFromString($filename, file_get_contents($path));
        $zip->renameName($filename, $field . "_" . $member->name . "." . $extension);
      }
    }

    $metadataFilepath = "temp/" . Str::random() . ".txt";
    Storage::put($metadataFilepath, $this->metadata);
    $zip->addFile(storage_path('app/' . $metadataFilepath), "metadata.txt");

    $zip->close();

    return $filePath;
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
      $committee = $committees->map(fn ($committee) => $committee->user)->find($user);

      return boolval($committee);
    }

    return false;
  }
}
