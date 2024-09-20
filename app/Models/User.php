<?php

namespace App\Models;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Administrator;
use App\Models\Contestant;
use App\Models\Committee;
use App\Models\Judge;
use App\Models\SuperAdministrator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail {
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'current_role_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = false;

    /**
     * All roles that belong to the user.
     * 
     * @return BelongsToMany
     */
    public function allRoles(): BelongsToMany {
        return $this->belongsToMany(Role::class)
            ->using(RoleUser::class)
            ->withPivot(["deleted_at"])
            ->withTimestamps();
    }

    /**
     * The active roles that belong to the user.
     * 
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class)
            ->using(RoleUser::class)
            ->withPivot(["deleted_at"])
            ->withTimestamps()
            ->wherePivotNull("deleted_at");
    }

    /**
     * Check if current user has any role provided.
     *
     * @param  array|string $roles
     * @param  bool         $withTrashed
     * @return bool
     */
    public function hasRole($roles, bool $withTrashed = false): bool {
        if (!is_array($roles)) $roles = [$roles];

        $availableRoles = $withTrashed ? $this->allRoles : $this->roles;

        return $availableRoles
            ->map(fn ($role) => $role->name)
            ->contains(fn ($role) => in_array($role, $roles));
    }

    /**
     * Check if current user has multiple roles.
     *
     * @return bool 
     */
    public function hasMultipleRoles(): bool {
        return $this->loadCount("roles")->roles_count > 1;
    }

    /**
     * Set relationship of active role
     *
     * @return BelongsTo
     */
    public function currentRole(): BelongsTo {
        return $this->belongsTo(Role::class, 'current_role_id');
    }

    /**
     * Determine if user has current role
     *
     * @return bool
     */
    public function hasCurrentRole(): bool {
        return $this->current_role_id !== null;
    }

    /**
     * Define alias for 'role' attribute.
     *
     * @return string|null
     */
    public function getRoleAttribute() {
        return $this->hasCurrentRole() ? $this->currentRole->name : null;
    }

    /**
     * Create user with user role form based on role.
     * 
     * @param string User role to be created.
     * @param array Contains email, password, role, and userable data.
     * @return User
     */
    public static function createUser(string $role, array $data): User {
        $user = new User();

        $user->fill($data);
        $user->save();
        $user->attachRole($role, $data);

        return $user;
    }

    /**
     * Attach role to user.
     * 
     * @param  string   User role to be attached.
     * @param  array    Contains userable data.
     * @return void
     */
    public function attachRole(string $role, array $data = []): void {
        if ($this->hasRole($role, true)) {

            $role = Role::findByName($role);
            $this->allRoles()->updateExistingPivot($role, ["deleted_at" => null]);
        } else {
            $userRoleModel = Role::createModelOfRole($role, array_merge($data, ["user_id" => $this->id]));
            $userRoleModel->save();

            $role = Role::findByName($role);
            $this->roles()->attach($role);

            if (!$this->currentRole) {
                $this->update(["current_role_id" => $role->id]);
            }
        }
    }

    /**
     * Detach role from user.
     * 
     * @param  string   User role to be detached.
     * @return void
     */
    public function detachRole(string $role): void {
        if ($this->hasRole($role, true)) {
            $role = Role::findByName($role);
            $this->roles()->updateExistingPivot($role, ["deleted_at" => now()]);

            if ($role->is($this->currentRole)) {
                $this->update(["current_role_id" => null]);
            }
        }
    }

    /**
     * Get relationship of user roles.
     * 
     * @param  string   Role.
     * @return UserMorph|null
     */
    public function userable(string $role) {
        if ($this->hasRole($role)) {
            switch ($role) {
                case Role::SUPERADMIN:
                    return $this->superadmin;
                case Role::ADMIN:
                    return $this->administrator;
                case Role::COMMITTEE:
                    return $this->committee;
                case Role::JUDGE:
                    return $this->judge;
                case Role::CONTESTANT:
                    return $this->contestant;
            }
        }

        return null;
    }

    /**
     * Define relationship for Super Administrator.
     * 
     * @return HasOne
     */
    public function superadmin() {
        return $this->hasOne(SuperAdministrator::class);
    }

    /**
     * Define relationship for Administrator.
     * 
     * @return HasOne
     */
    public function administrator() {
        return $this->hasOne(Administrator::class);
    }

    /**
     * Define relationship for Committee.
     * 
     * @return HasOne
     */
    public function committee() {
        return $this->hasOne(Committee::class);
    }

    /**
     * Define relationship for Judge.
     * 
     * @return HasOne
     */
    public function judge() {
        return $this->hasOne(Judge::class);
    }

    /**
     * Define relationship for Contestant.
     * 
     * @return HasOne
     */
    public function contestant() {
        return $this->hasOne(Contestant::class);
    }

    /**
     * Query builder if user is soft-deleted.
     * 
     * @return void
     */
    public function scopeTrashed(Builder $builder, $trashed = true): void {
        $operator = $trashed ? "=" : "!=";
        $builder->where("deleted_at", $operator, null);
    }
}
