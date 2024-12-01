<!-- resources/views/tasks/index.blade.php -->
@extends('admin.dashboard')

@section('content')

<div class="container">
    <h1 class="my-4">Tasks List</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create Task</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- Filter Form -->
    <form action="{{ route('tasks.index') }}" method="GET" class="mb-4">
        <div class="form-row align-items-center">
            <div class="col-auto">
                <label class="sr-only" for="status">Status</label>
                <select name="status" id="status" class="form-control mb-2">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2">Filter</button>
            </div>
            <div class="col-auto">
                <label class="sr-only" for="search">Search</label>
                <input type="text" name="search" id="search" class="form-control mb-2" placeholder="Search tasks" value="{{ request('search') }}">
                
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
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
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->user->name ?? 'null' }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm mr-2">
                                <i class="fas fa-edit"></i> 
                            </a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mr-2">
                                    <i class="fas fa-trash-alt"></i> 
                                </button>
                            </form>
                            @if($task->status == 'pending')
                                <a href="{{ route('tasks.showAssignForm', $task->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-user-plus"></i> 
                                </a>
                            @endif
                        </div>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Links -->
<div class="d-flex justify-content-center">
    {{ $tasks->links('vendor.pagination.bootstrap-4') }}
</div>
</div>
<!-- Chart Container -->
<div class="my-4">
    <canvas id="taskStatusChart"></canvas>
</div>

<script>
    // Prepare data for the chart
    const taskData = @json($tasks);
    const statusCounts = {
        pending: 0,
        'in-progress': 0,
        completed: 0
    };

    taskData.forEach(task => {
        statusCounts[task.status]++;
    });

    const ctx = document.getElementById('taskStatusChart').getContext('2d');
    const taskStatusChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pending', 'In Progress', 'Completed'],
            datasets: [{
                data: [statusCounts.pending, statusCounts['in-progress'], statusCounts.completed],
                backgroundColor: ['#f39c12', '#3498db', '#2ecc71']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const total = tooltipItem.dataset.data.reduce((sum, value) => sum + value, 0);
                            const value = tooltipItem.raw;
                            const percentage = ((value / total) * 100).toFixed(2);
                            return `${tooltipItem.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection