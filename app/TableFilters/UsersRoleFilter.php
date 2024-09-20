<?php

namespace App\TableFilters;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Filters\BooleanFilter;
use App\Models\Role;

class UsersRoleFilter extends BooleanFilter {
    /**
     * Title to be rendered in filter box
     *
     * @var string
     */
    protected $title = "Roles";

    /**
     * Modify the current query when the filter is used
     *
     * @param  Builder  $query Current query
     * @param  Array    $value Associative array with the boolean value for each of the options
     * @return Builder  Modified query
     */
    public function apply(Builder $query, $value): Builder {
        if ($value[Role::SUPERADMIN]) {
            $query->orWhereRelation("roles", "name", Role::SUPERADMIN);
        }

        if ($value[Role::ADMIN]) {
            $query->orWhereRelation("roles", "name", Role::ADMIN);
        }

        if ($value[Role::COMMITTEE]) {
            $query->orWhereRelation("roles", "name", Role::COMMITTEE);
        }

        if ($value[Role::JUDGE]) {
            $query->orWhereRelation("roles", "name", Role::JUDGE);
        }

        if ($value[Role::CONTESTANT]) {
            $query->orWhereRelation("roles", "name", Role::CONTESTANT);
        }

        return $query;
    }

    /**
     * Defines the title and value for each option
     *
     * @return array associative array with the title and values
     */
    public function options(): array {
        $map = Role::getRolesMap();
        $roles = [];

        foreach ($map as $name => $value) {
            $title = $value["title"];
            $roles[$title] = $name;
        }

        return $roles;
    }
}
