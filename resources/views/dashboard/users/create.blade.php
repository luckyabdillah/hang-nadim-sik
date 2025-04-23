@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Create New User</h5>
        <div class="card-body">
            <a href="/dashboard/users" class="btn btn-secondary mb-3">Back</a>
            <form action="/dashboard/users" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="User Name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="User email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" required>
                    @error('password')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select @error('role') is-invalid @enderror" name="role" id="role" required>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="applicant" {{ old('role') == 'applicant' ? 'selected' : '' }}>Applicant</option>
                        <option value="verificator" {{ old('role') == 'verificator' ? 'selected' : '' }}>Verificator</option>
                        <option value="approver" {{ old('role') == 'approver' ? 'selected' : '' }}>Approver</option>
                        <option value="avsec" {{ old('role') == 'avsec' ? 'selected' : '' }}>Avsec</option>
                        <option value="superuser" {{ old('role') == 'superuser' ? 'selected' : '' }}>Super User</option>
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
