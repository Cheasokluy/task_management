@extends('admin.dashboard')

@section('content')
<div class="container">
    <h1 class="my-4">Users</h1>
    <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">Create New User</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- Search and Filter Form -->
    <form action="{{ route('admin.userList') }}" method="GET" class="mb-4">
        <div class="form-row align-items-center">
            <div class="col-auto">
                <label class="sr-only" for="search">Search</label>
                <input type="text" name="search" id="search" class="form-control mb-2" placeholder="Search users" value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <label class="sr-only" for="sort">Sort</label>
                <select name="sort" id="sort" class="form-control mb-2">
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A-Z</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z-A</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2">Search & Filter</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('admin.show', $user->id) }}" class="btn btn-info btn-sm">Details</a>
                        <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $users->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
@endsection