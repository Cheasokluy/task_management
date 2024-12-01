<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\UserTask;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user

        $user = Auth::user();
        // Get the tasks of the authenticated user

        $tasks = $user->tasks;

        // Get user tasks
        $userTasks = UserTask::where('user_id', $user->id)->get();

        return view('user.dashboard', compact('tasks','userTasks'));
    }
}
