<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();
        $status = $request->input('status');
        $search = $request->input('search');

        $tasks = Task::when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        })->paginate(10);


        return view('tasks.index', compact('tasks', 'status', 'search'));
    }

    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }
    public function createTaskFouruser($id)
    {
        $user = User::findOrFail($id);
        $users = User::all();
        return view('admin.users.createTaskForuser', compact('user','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:pending,in-progress,completed',
            'due_date' => 'nullable|date',
            'user_id' => 'nullable|exists:users,id',
        ]);
    
        $task = Task::create($request->only(['title', 'description', 'status', 'due_date', 'user_id']));
    
        
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:pending,in-progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($request->only(['title', 'description', 'status', 'due_date']));

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function updateProgress(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->progress = $request->input('progress');
        $task->save();

        return redirect()->route('user.dashboard')->with('success', 'Task progress updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function assignUser(Request $request, Task $task)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        UserTask::create([
            'user_id' => $request->user_id,
            'task_id' => $task->id,
        ]);
        $task->user_id = $request->user_id;
        $task->status = 'in-progress';
        $task->save();
        

        return redirect()->route('tasks.index')->with('success', 'User assigned to task successfully.');
    }
    public function createTaskForUserByAdmin(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:pending,in-progress,completed',
            'due_date' => 'nullable|date',
            'user_id' => 'nullable|exists:users,id',
        ]);
    
        $task = Task::create($request->only(['title', 'description', 'status', 'due_date', 'user_id']));
        // dd($task);
        UserTask::create([
            'user_id' => $request->user_id,
            'task_id' => $task->id,
        ]);
        
        

        return redirect()->route('admin.show', ['id' => $request->input('user_id')])->with('success', 'Task created successfully.');
    }

    //create task for user form by admin
    public function createTaskForuser($id)
    {
        $user = User::findOrFail($id);
        // dd($user);
        return view('admin.users.createTaskForuser', compact('user'));
    }
    public function showAssignForm(Task $task)
    {
        $users = User::all();
        return view('tasks.assign', compact('task', 'users'));
    }
    public function updateStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->status = $request->input('status');
        $task->save();

        return redirect()->route('user.dashboard')->with('success', 'Task status updated successfully.');
    }
}
