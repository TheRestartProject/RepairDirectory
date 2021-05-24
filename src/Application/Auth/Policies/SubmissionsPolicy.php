<?php

namespace TheRestartProject\RepairDirectory\Application\Auth\Policies;

use TheRestartProject\RepairDirectory\Domain\Models\Submission;
use TheRestartProject\Fixometer\Domain\Entities\User;

class SubmissionsPolicy
{
    public function before(User $user)
    {
        if ($user->isSuperAdmin($user)) {
            return true;
        }
    }

    public function index(User $user)
    {
        if ($user->isRegionalAdmin() || $user->isEditor())
            return true;
    }

    public function view(User $user)
    {
        if ($user->isRegionalAdmin() || $user->isEditor())
            return true;
    }

    public function update(User $user)
    {
        if ($user->isSuperAdmin() || $user->isRegionalAdmin())
            return true;
    }
}
