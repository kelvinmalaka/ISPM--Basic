<?php

namespace App\File;

use App\File\FilePermission;
use App\Models\User;
use App\Models\Answer;
use App\Models\ContestCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class AnswerFile extends FilePermission {
  /**
   * Path of the file.
   *
   * @var Answer 
   */
  protected Answer $answer;

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
  protected string $metadata = "TEAM ANSWER DATA";

  /**
   * Class constructor.
   *
   * @param   int  $id
   * @return  void
   */
  public function __construct(Answer $answer) {
    $this->answer = $answer;
    $this->category = $answer->team->contestCategory;
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
    $answer = $this->answer;
    $team = $answer->team;
    $details = $answer->details;

    $tempPath = storage_path('app/temp/');
    if (!File::isDirectory($tempPath)) {
      File::makeDirectory($tempPath, 0777, true, true);
    }

    $zip = new ZipArchive();
    $fileName = "Team Answer " . $team->id .  ".zip";
    $filePath = $tempPath . $fileName;

    $zip->open($filePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    $this->addInformation("Submitted at", Carbon::toLocale($answer->created_at));
    $this->addInformation("Answer ID", $answer->id);
    $this->addInformation("Team ID", $team->id);
    $this->addInformation("Team Name", $team->name);
    $this->addInformation("Team University", $team->university);
    $this->addInformation("Contest", $team->contest->title);
    $this->addInformation("Contest Category", $team->category->title);
    $this->addInformation();

    foreach ($details as $detail) {
      $path = explode(".", $detail->file_path);
      $extension = $path[count($path) - 1];

      $path = storage_path('app/' . $detail->file_path);
      $filename = basename($path);

      $zip->addFromString($filename, file_get_contents($path));
      $zip->renameName($filename, $detail->type->name . "." . $extension);
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
      $committee = $committees->map(fn ($committee) => $committee->user)->first(fn ($committee) => $committee->is($user));

      return boolval($committee);
    }

    if ($user->role === "judge") {
      $components = $this->category->assessmentComponents()->with("judges.user")->get();
      $judges = $components->map(fn ($component) => $component->judges)->flatten();
      $judge = $judges->map(fn ($judge) => $judge->user)->first(fn ($judge) => $judge->is($user));

      return boolval($judge);
    }

    if ($user->role === "contestant") {
      $team = $this->answer->team()->with("contestant.user")->first();
      return $team->contestant->user->is($user);
    }

    return false;
  }
}
