@extends('admin.dashboard')

@section('content')
<div class="container">
    <h1 class="my-4">Task Details</h1>
    <div class="card">
        <div class="card-header">
            <h2>{{ $task->title }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $task->description }}</p>
            <p><strong>Status:</strong> {{ $task->status }}</p>
            <p><strong>Assigned User:</strong> {{ $task->user->name ?? 'Unassigned' }}</p>
            <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
            <p><strong>Progress:</strong></p>
            <div class="progress mb-3">
                <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%;" aria-valuenow="{{ $task->progress }}" aria-valuemin="0" aria-valuemax="100">{{ $task->progress }}%</div>
            </div>
            {{-- <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit Task
            </a> --}}
        </div>
        <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>
@endsection