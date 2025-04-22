@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Create New Location</h5>
        <div class="card-body">
            <a href="/dashboard/work-locations" class="btn btn-secondary mb-3">Back</a>
            <form action="/dashboard/work-locations" method="post">
                @csrf
                <div class="mb-3">
                    <label for="location" class="form-label">Location Name</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror " id="location" name="location" value="{{ old('location') }}" placeholder="Location Name" required autofocus>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection 