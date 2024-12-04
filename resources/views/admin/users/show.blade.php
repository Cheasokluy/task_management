@extends('admin.dashboard')

@section('content')
<div class="container">
    <h1 class="my-4">User Details</h1>
    <div class="card">
        <div class="card-header">
            <h2>{{ $user->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
            <p><strong>Total Tasks:</strong> {{ $totalTasks }}</p>
            <p><strong>Completed Tasks:</strong> {{ $completedTasksCount }}</p>
            <p><strong>Not Completed Tasks:</strong> {{ $notCompletedTasksCount }}</p>

            <a href="{{ route('admin.createTaskForuser', $user->id) }}" 
                class="btn btn-primary">Create Task for {{ $user->name }}
            </a>
            {{-- <a href="{{ route('admin.show', $user->id) }}" class="btn btn-info btn-sm">Details</a>     --}}
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.userList') }}" class="btn btn-primary">Back to User List</a>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h2>Not Completed Tasks Assigned to {{ $user->name }}</h2>
        </div>
        <div class="card-body">
            @if($user->tasks->where('status', '!=', 'completed')->isEmpty())
                <p class="text-muted">No not completed tasks assigned to this user.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notCompletedTasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->status }}</td>
                                <td>{{ $task->due_date }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%;" aria-valuenow="{{ $task->progress }}" aria-valuemin="0" aria-valuemax="100">{{ $task->progress }}%</div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer">
            {{ $notCompletedTasks->links('../vendor.pagination.bootstrap-4') }}
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h2>Completed Tasks Assigned to {{ $user->name }}</h2>
        </div>
        <div class="card-body">
            @if($user->tasks->where('status', 'completed')->isEmpty())
                <p class="text-muted">No completed tasks assigned to this user.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedTasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->status }}</td>
                                <td>{{ $task->due_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer">
            {{ $completedTasks->links('../vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection