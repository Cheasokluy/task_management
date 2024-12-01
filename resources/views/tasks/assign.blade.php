@extends('admin.dashboard')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="my-4">Assign Task</h1>
            <div class="card">
                <div class="card-header">
                    <h2>Assign Task to User</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.assignUser', $task->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">Assign to User</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection