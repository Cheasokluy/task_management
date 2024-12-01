<!-- resources/views/tasks/create.blade.php -->
@extends('admin.dashboard')

@section('content')
<div class="container">
    <h1 class="my-4">Create Task</h1>
    <form action="{{ route('admin.tasks.createTaskForUserByAdmin') }}" method="POST">
        @csrf
        <input type="hidden" name="source" value="{{ request('user_id') ? 'user' : 'tasks' }}">
        <input type="hidden" name="user_id" value="{{ request('user_id') }}">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="in-progress">In Progress</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" class="form-control">
        </div>
        <div class="form-group">
            <label for="user_id">Assign to User</label>
            <select class="form-control" id="user_id" name="user_id">
                
            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>
</div>
@endsection