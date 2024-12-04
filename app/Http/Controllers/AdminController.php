<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index()
    {
        $pendingTasks = Task::where('status', 'pending')->paginate(5, ['*'], 'pendingTasks');
        $inProgressTasks = Task::where('status', 'in-progress')->paginate(5, ['*'], 'inProgressTasks');
        $completedTasks = Task::where('status', 'completed')->paginate(5, ['*'], 'completedTasks');
        $users = User::all();
        $tasks = Task::all();
        $taskCounts = [
            'pending' => $tasks->where('status', 'pending')->count(),
            'in-progress' => $tasks->where('status', 'in-progress')->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
        ];

        //prepare data for the line chart
        $completedTasksOverTime = Task::where('status', 'completed')
            // ->selectRaw('DATE(completed_at) as date, COUNT(*) as count')
            // ->groupBy('date')
            // ->orderBy('date')
            // ->get();
            ->selectRaw('DATE_FORMAT(completed_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'tasks',
            'taskCounts',
            'users',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'completedTasksOverTime'
        ));
    }

    public function userList(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'asc'); // Default to ascending order

        $users = User::withCount('tasks')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            })
            ->orderBy('name', $sort)
            ->paginate(10); // Adjust the number as needed
        // dd($users->tasks_count);

        return view('admin.users.index', compact('users', 'search', 'sort'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);
        // dd($request->all());

        return redirect()->route('admin.userList')->with('success', 'User created successfully.');
    }
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Paginate not completed and completed tasks
        $notCompletedTasks = Task::where('user_id', $user->id)
            ->where('status', '!=', 'completed')
            ->paginate(5, ['*'], 'notCompletedTasks');

        $completedTasks = Task::where('user_id', $user->id)
            ->where('status', 'completed')
            ->paginate(5, ['*'], 'completedTasks');

        $totalTasks = $user->tasks->count();
        $completedTasksCount = $user->tasks->where('status', 'completed')->count();
        $notCompletedTasksCount = $totalTasks - $completedTasksCount;

        return view('admin.users.show', compact('user', 'totalTasks', 'completedTasksCount', 'notCompletedTasksCount', 'notCompletedTasks', 'completedTasks'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.userList')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.userList')->with('success', 'User deleted successfully.');
    }
}
