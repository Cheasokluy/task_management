<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Task $task)
    {
        return $user->id === $task->user_id || $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Task $task)
    {
        return $user->role === 'admin';
    }
}
