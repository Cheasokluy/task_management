@extends('admin.dashboard')

@section('content')
<div class="container mt-5">
    <h1 class="my-4">Login Activities</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>IP Address</th>
                <th>User Agent</th>
                <th>Login At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loginActivities as $activity)
                <tr>
                    <td>{{ $activity->user->name }}</td>
                    <td>{{ $activity->ip_address }}</td>
                    <td>{{ $activity->user_agent }}</td>
                    <td>{{ $activity->login_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection