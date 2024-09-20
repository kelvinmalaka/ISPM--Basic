<?php

namespace App\Models;

use App\Models\User;
use App\Models\RoleUser;
use App\Models\UserMorph;
use App\Models\Administrator;
use App\Models\Contestant;
use App\Models\Committee;
use App\Models\Judge;
use App\Models\SuperAdministrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Exception;

class Role extends Model {
    use HasFactory;

    public const SUPERADMIN = "superadmin";
    public const ADMIN = "administrator";
    public const JUDGE = "judge";
    public const COMMITTEE = "committee";
    public const CONTESTANT = "contestant";

    /**
     * Map of available roles.
     *
     * @var array
     */
    private const ROLES_MAP = [
        self::SUPERADMIN => [
            "model" => SuperAdministrator::class,
            "title" => "Super Administrator"
        ],
        self::ADMIN => [
            "model" => Administrator::class,
            "title" => "Administrator"
        ],
        self::JUDGE => [
            "model" => Judge::class,
            "title" => "Judge"
        ],
        self::COMMITTEE => [
            "model" => Committee::class,
            "title" => "Committee"
        ],
        self::CONTESTANT => [
            "model" => Contestant::class,
            "title" => "Contestant"
        ]
    ];

    /**
     * Get available roles.
     *
     * @return array
     */
    public static function getRolesMap(): array {
        return self::ROLES_MAP;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'title'];

    /**
     * Retrieve corresponding user model path based on role.
     *
     * @param  string     Role defined in available roles.
     * @return string
     * @throws Exception
     */
    private static function getUserableModel(string $role): string {
        if (array_key_exists($role, self::ROLES_MAP)) {
            return self::ROLES_MAP[$role]["model"];
        }

        throw new Exception("User role is not found");
    }

    /**
     * Create user morph model based on role.
     *
     * @param  string     Role defined in available roles.
     * @param  array|null Initiation data of model.
     * @return UserMorph
     */
    public static function createModelOfRole($role, $data = null): UserMorph {
        $modelPath = self::getUserableModel($role);

        $model = new $modelPath;
        if ($data) $model->fill($data);

        return $model;
    }

    /**
     * The users that belong to the role.
     * 
     * @return BelongsToMany
     */
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class)
            ->using(RoleUser::class)
            ->withPivot(["deleted_at"])
            ->withTimestamps()
            ->wherePivotNull("deleted_at");
    }

    /**
     * Find role entity by name.
     * 
     * @param  string   $role
     * @return Role
     */
    public static function findByName(string $role): Role {
        return self::query()
            ->where("name", $role)
            ->first();
    }
}
