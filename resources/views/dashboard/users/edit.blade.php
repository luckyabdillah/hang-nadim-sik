@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Edit User</h5>
        <div class="card-body">
            <a href="/dashboard/users" class="btn btn-secondary mb-3">Back</a>
            <form action="/dashboard/users/{{ $user->uuid }}" method="POST">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="User Name" value="{{ old('name', $user->name) }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="User email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select @error('role') is-invalid @enderror" name="role" id="role" required>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="applicant" {{ old('role', $user->role) == 'applicant' ? 'selected' : '' }}>Applicant</option>
                        <option value="verificator" {{ old('role', $user->role) == 'verificator' ? 'selected' : '' }}>Verificator</option>
                        <option value="approver" {{ old('role', $user->role) == 'approver' ? 'selected' : '' }}>Approver</option>
                        <option value="avsec" {{ old('role', $user->role) == 'avsec' ? 'selected' : '' }}>Avsec</option>
                        <option value="superuser" {{ old('role', $user->role) == 'superuser' ? 'selected' : '' }}>Super User</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
