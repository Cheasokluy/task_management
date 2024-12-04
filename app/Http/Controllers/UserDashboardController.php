<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\UserTask;
use App\Notifications\TaskDeadlineNotification;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user

        $user = Auth::user();
        // Get the tasks of the authenticated user

        $tasks = $user->tasks;

        // Paginate in-progress and completed tasks directly from the database
        $inProgressTasks = Task::where('user_id', $user->id)
            ->where('status', 'in-progress')
            ->paginate(3, ['*'], 'inProgressTasks');

        $completedTasks = Task::where('user_id', $user->id)
            ->where('status', 'completed')
            ->paginate(5, ['*'], 'completedTasks');

            // dd($inProgressTasks);

        // Get user tasks
        $userTasks = UserTask::where('user_id', $user->id)->get();

        // $tasksApproachingDeadline = $tasks->filter(function ($task) {
        //     return Carbon::parse($task->due_date)->isToday() || Carbon::parse($task->due_date)->isTomorrow() || Carbon::parse($task->due_date)->isSameDay(Carbon::now()->addDays(2));
        // });

        // Check for tasks approaching their deadlines (due today or within the next 3 days)
        $tasksApproachingDeadline = Task::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'in-progress'])
            ->where(function ($query) {
                $query->whereDate('due_date', Carbon::today())
                    ->orWhereDate('due_date', Carbon::tomorrow())
                    ->orWhereDate('due_date', Carbon::now()->addDays(2));
            })
            ->get();

        // Send notifications for tasks approaching their deadlines
        foreach ($tasksApproachingDeadline as $task) {
            $task->user->notify(new TaskDeadlineNotification($task));

        }

        //mark all notifications as read
        $user->unreadNotifications->markAsRead();

        return view('user.dashboard', compact('inProgressTasks', 'completedTasks','tasks','userTasks'));
    }
}
