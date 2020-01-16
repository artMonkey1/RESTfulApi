<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Worker;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkerPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * Determine whether the user can dismiss from the company.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Worker  $worker
     * @return mixed
     */
    public function manageJobs(User $user, Worker $worker)
    {
        return $user->id == $worker->id;
    }

}
