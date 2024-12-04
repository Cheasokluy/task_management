@extends('../admin.dashboard')

@section('title', 'User Dashboard')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="my-4">User Dashboard</h1>
            <p class="lead">Welcome to your dashboard!</p>
            <!-- Display Notifications -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (auth()->user()->unreadNotifications->count() > 0)
                <div class="alert alert-info">
                    <h4>You have {{ auth()->user()->unreadNotifications->count() }} new notifications</h4>
                    <ul>
                        @foreach (auth()->user()->unreadNotifications as $notification)
                            <li>
                                {{ $notification->data['title'] }} is due on {{ $notification->data['due_date'] }}
                                <a href="{{ route('tasks.show', $notification->data['task_id']) }}">View Task</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="card">
                <div class="card-header">
                    <h2>In-Progress Tasks</h2>
                </div>
                <div class="card-body">
                    @if($tasks->where('status', 'in-progress')->isEmpty())
                        <p class="text-muted">You have no in-progress tasks.</p>
                    @else
                        <div class="row">
                            @foreach($inProgressTasks->where('status', 'in-progress') as $task)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $task->title }}</h5>
                                            <p class="card-text">{{ $task->description }}</p>
                                            <p class="card-text"><strong>Status:</strong> {{ $task->status }}</p>
                                            <p class="card-text"><strong>Assigned User:</strong> {{ $task->user->name ?? 'null' }}</p>
                                            <p class="card-text"><strong>Due Date:</strong> {{ $task->due_date }}</p>
                                            <div class="progress mb-3">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%;" aria-valuenow="{{ $task->progress }}" aria-valuemin="0" aria-valuemax="100">{{ $task->progress }}%</div>
                                            </div>
                                            <form action="{{ route('tasks.updateProgress', $task->id) }}" method="POST" id="progress-form-{{ $task->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="progress-{{ $task->id }}">Update Progress</label>
                                                    <input type="number" class="form-control" id="progress-{{ $task->id }}" name="progress" value="{{ $task->progress }}" min="0" max="100" onchange="checkProgress({{ $task->id }})">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Progress</button>
                                            </form>
                                            <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST" id="status-form-{{ $task->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <div class="form-check mt-3" id="completion-check-{{ $task->id }}" style="display: none;">
                                                    <input class="form-check-input" type="checkbox" id="task-completed-{{ $task->id }}" onchange="submitStatusForm({{ $task->id }})">
                                                    <label class="form-check-label" for="task-completed-{{ $task->id }}">
                                                        Mark as Completed
                                                    </label>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    {{ $inProgressTasks->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h2>Completed Tasks</h2>
                </div>
                <div class="card-body">
                    @if($tasks->where('status', 'completed')->isEmpty())
                        <p class="text-muted">You have no completed tasks.</p>
                    @else
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Assigned User</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($completedTasks->where('status', 'completed') as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->status }}</td>
                                        <td>{{ $task->user->name ?? 'Unassigned' }}</td>
                                        <td>{{ $task->due_date }}</td>
                                        <td>
                                            <i class="fas fa-check text-success"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="card-footer">
                    {{ $completedTasks->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function checkProgress(taskId) {
        const progressInput = document.getElementById(`progress-${taskId}`);
        const progressValue = progressInput.value;

        if (progressValue == 100) {
            document.getElementById(`completion-check-${taskId}`).style.display = 'block';
        } else {
            document.getElementById(`completion-check-${taskId}`).style.display = 'none';
        }
    }

    function submitStatusForm(taskId) {
        document.getElementById(`status-form-${taskId}`).submit();
    }
</script>
@endsection