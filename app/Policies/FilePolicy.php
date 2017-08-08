<?php

namespace App\Policies;

use App\{
    File,
    User
};
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    public function touch(User $user, File $file)
    {
        return $user->id === $file->user_id;
    }
}
