<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot {
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "role_user";

    public function getIdAttribute(): string {
        return $this->user->id . "_" . $this->role->id;
    }

    /**
     * Get the role that this pivot row belongs to.
     */
    public function role() {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user that this pivot row belongs to.
     */
    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Determine if role is soft-deleted.
     * 
     * @return bool
     */
    public function trashed(): bool {
        $status = boolval($this->deleted_at);
        return $status;
    }

    /**
     * Soft-delete role.
     * 
     * @return bool
     */
    public function delete(): bool {
        $role = $this->role->name;
        $this->user->detachRole($role);

        return true;
    }

    /**
     * Restore soft-deleted role.
     * 
     * @return bool
     */
    public function restore(): bool {
        $role = $this->role->name;
        $this->user->attachRole($role);

        return true;
    }
}
