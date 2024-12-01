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
        $users = User::all();
        $tasks = Task::all();
        $taskCounts = [
            'pending' => $tasks->where('status', 'pending')->count(),
            'in-progress' => $tasks->where('status', 'in-progress')->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
        ];
        return view('admin.dashboard', compact('tasks', 'taskCounts', 'users'));
    }

    public function userList(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'asc'); // Default to ascending order
    
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('role', 'like', "%{$search}%");
        })->orderBy('name', $sort)->paginate(10); // Adjust the number as needed
    
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
        $user = User::with('tasks')->findOrFail($id);
        $totalTasks = $user->tasks->count();
        $completedTasks = $user->tasks->where('status', 'completed')->count();
        $notCompletedTasks = $totalTasks - $completedTasks;

        return view('admin.users.show', compact('user', 'totalTasks', 'completedTasks', 'notCompletedTasks'));
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
