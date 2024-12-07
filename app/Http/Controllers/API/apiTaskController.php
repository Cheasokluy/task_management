<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class apiTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required',
    //         'description' => 'nullable',
    //         'status' => 'required|in:pending,in-progress,completed',
    //         'user_id' => 'required|exists:users,id',
    //         'due_date' => 'nullable|date',
    //     ]);

    //     return Task::create($request->all());
    // }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $task;
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Task $task)
    // {
    //     $request->validate([
    //         'title' => 'required',
    //         'description' => 'nullable',
    //         'status' => 'required|in:pending,in-progress,completed',
    //         'user_id' => 'required|exists:users,id',
    //         'due_date' => 'nullable|date',
    //     ]);

    //     $task->update($request->all());

    //     return $task;
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Task $task)
    // {
    //     $task->delete();

    //     return response()->noContent();
    // }
}
