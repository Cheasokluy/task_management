<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this user?')) {
                event.target.submit();
            }
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        {{-- //check if the user is admin --}}
        @if(auth()->user()->role === 'admin')

        <a class="navbar-brand" href="{{ route('admin.dashboard')}}">Admin Dashboard</a>
        @else
        <a class="navbar-brand" href="#">User Dashboard</a>
        @endif
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                
                @if(auth()->user()->role === 'admin')
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a>
              </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.userList') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.loginActivities') }}">LoginActivities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.taskActivities') }}">LoginActivities</a>
                </li>
                @endif
            </ul>
        </div>
        <span class="nav-item navbar-text">
            Welcome, {{ auth()->user()->name }} 
            &nbsp;
        </span>
        

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <button class="btn btn-outline-danger my-2 my-sm-0" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </button>
    </nav>
    
    @hasSection('content')
        @yield('content')
    @else
        {{-- <!-- Chart Container -->
        <div class="my-4 chart-container">
            <canvas id="taskStatusChart"></canvas>
            <!-- Chart Container -->

        </div> --}}
        <!-- Line Chart Container -->
    <div class="card mt-4 chart-container">
        <canvas id="taskStatusChart"></canvas>
        <div class="card-header">
            <h3>Tasks Completed Over Time</h3>
        </div>
        <div class="card-body">
            <canvas id="completedTasksChart"></canvas>
        </div>
    </div>
        <div class="container mt-5">
            <h1 class="my-4">Admin Dashboard</h1>
        
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-white">
                            <h3>Pending Tasks</h3>
                        </div>
                        <div class="card-body">
                            @if($pendingTasks->isEmpty())
                                <p class="text-muted">No pending tasks.</p>
                            @else
                                <ul class="list-group">
                                    @foreach($pendingTasks as $task)
                                        <li class="list-group-item">
                                            <strong>{{ $task->title }}</strong>
                                            <p>{{ $task->description }}</p>
                                            <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <!-- Pagination Links -->
                        <div class="card-footer">
                            {{ $pendingTasks->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
        
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h3>In-Progress Tasks</h3>
                        </div>
                        <div class="card-body">
                            @if($inProgressTasks->isEmpty())
                                <p class="text-muted">No in-progress tasks.</p>
                            @else
                                <ul class="list-group">
                                    @foreach($inProgressTasks as $task)
                                        <li class="list-group-item">
                                            <strong>{{ $task->title }}</strong>
                                            <p>{{ $task->description }}</p>
                                            <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="card-footer">
                            {{ $inProgressTasks->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
        
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h3>Completed Tasks</h3>
                        </div>
                        <div class="card-body">
                            @if($completedTasks->isEmpty())
                                <p class="text-muted">No completed tasks.</p>
                            @else
                                <ul class="list-group">
                                    @foreach($completedTasks as $task)
                                        <li class="list-group-item">
                                            <strong>{{ $task->title }}</strong>
                                            <p>{{ $task->description }}</p>
                                            <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
                                        </li>
                                    @endforeach
                                </ul>
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
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('taskStatusChart').getContext('2d');
                const taskStatusChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Pending', 'In Progress', 'Completed'],
                        datasets: [{
                            label: 'Number of Tasks',
                            data: [{{ $taskCounts['pending'] }}, {{ $taskCounts['in-progress'] }}, {{ $taskCounts['completed'] }}],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(75, 192, 192, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                const lineChat = document.getElementById('completedTasksChart').getContext('2d');
                const completedTasksChart = new Chart(lineChat, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($completedTasksOverTime->pluck('month')) !!},
                        datasets: [{
                            label: 'Tasks Completed',
                            data: {!! json_encode($completedTasksOverTime->pluck('count')) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: true,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                    });
                    // Debugging: Log the data to the console
        console.log('Labels:', {!! json_encode($completedTasksOverTime->pluck('month')) !!});
        console.log('Data:', {!! json_encode($completedTasksOverTime->pluck('count')) !!});
        </script>
        <style>
            .chart-container {
                width: 50%; /* Adjust the width as needed */
                margin: 0 auto; /* Center the chart */
            }
        </style>
    @endif
   

<!-- Other dashboard content -->


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

