<?php

namespace App\Traits\Roles;

use Illuminate\Database\Eloquent\Builder;
use App\Role;

trait HasRoles
{
    public function hasRole($roleName)
    {
        if (!$this->roles->contains('name', $roleName)) {
            return false;
        }

        return true;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
