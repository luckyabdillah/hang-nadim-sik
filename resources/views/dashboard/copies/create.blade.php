@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Create New Copy</h5>
        <div class="card-body">
            <a href="/dashboard/copies" class="btn btn-secondary mb-3">Back</a>
            <form action="/dashboard/copies" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Copy Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Copy Name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
