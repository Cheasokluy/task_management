@extends('admin.dashboard')

@section('content')
<div class="container mt-5">
    <h1 class="my-4">Task Activities</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Task</th>
                <th>User</th>
                <th>Activity</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($taskActivities as $activity)
                <tr>
                    <td>{{ $activity->task->title }}</td>
                    <td>{{ $activity->user->name }}</td>
                    <td>{{ $activity->activity }}</td>
                    <td>{{ $activity->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection