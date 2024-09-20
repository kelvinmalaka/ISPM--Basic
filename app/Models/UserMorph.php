<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMorph extends Model {
  use HasFactory;

  /**
   * Indicates if all mass assignment is enabled.
   *
   * @var bool
   */
  protected static $unguarded = false;

  /**
   * Indicates if the model should be timestamped.
   *
   * @var boolean
   */
  public $timestamps = false;

  /**
   * The relationships that should always be loaded.
   *
   * @var array
   */
  protected $with = ['user'];

  /**
   * Model constructor.
   *
   * @return void
   */
  public function __construct(array $attributes = array()) {
    parent::__construct($attributes);

    $this->fillable(array_merge($this->fillable, ["user_id"]));
  }

  /**
   * Define relationship for user.
   * 
   * @return BelongsTo
   */
  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }
}
