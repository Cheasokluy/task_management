@extends('../admin.dashboard')

@section('title', 'User Dashboard')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="my-4">User Dashboard</h1>
            <p class="lead">Welcome to your dashboard!</p>
            <div class="card">
                <div class="card-header">
                    <h2>Your Tasks</h2>
                </div>
                <div class="card-body">
                    @if($tasks->isEmpty())
                        <p class="text-muted">You have no tasks.</p>
                    @else
                        <div class="row">
                            @foreach($tasks as $task)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $task->title }}</h5>
                                            <p class="card-text">{{ $task->description }}</p>
                                            <p class="card-text"><strong>Status:</strong> {{ $task->status }}</p>
                                            <p class="card-text"><strong>Assigned User:</strong> {{ $task->user->name }}</p>
                                            <p class="card-text"><strong>Due Date:</strong> {{ $task->due_date }}</p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection