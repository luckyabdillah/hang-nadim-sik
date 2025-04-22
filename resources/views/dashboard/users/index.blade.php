@extends('dashboard.layouts.main')

@section('content')
<div class="card">
    <h5 class="card-header">Users List</h5>
    <div class="card-body">
        <a href="/dashboard/users/create" class="btn btn-primary mb-4">Create New User</a>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th style="width: 1px;">No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->count()) @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <a href="/dashboard/users/{{ $user->uuid }}/edit" class="btn btn-warning rounded-pill">
                            <i class="bx bx-edit-alt"></i>
                        </a>
                        <form action="/dashboard/users/{{ $user->uuid }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-delete rounded-pill">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach @else
                <tr>
                    <td colspan="5">No data found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection