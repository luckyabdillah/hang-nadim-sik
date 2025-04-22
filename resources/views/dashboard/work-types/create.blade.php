@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Create New Work Type</h5>
        <div class="card-body">
            <a href="/dashboard/work-types" class="btn btn-secondary mb-3">Back</a>
            <form action="/dashboard/work-types" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="type" class="form-label">Work Type</label>
                    <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type" placeholder="Work Type" value="{{ old('type') }}" required autofocus>
                    @error('type')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div> 
                <div class="mb-3">
                    <label for="provision_text_before" class="form-label">Provision Text Before</label>
                    <textarea class="form-control @error('provision_text_before') is-invalid @enderror" name="provision_text_before" id="provision_text_before" placeholder="Provision Text Before" required>{{ old('provision_text_before') }}</textarea>
                    @error('provision_text_before')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div> 
                <div class="mb-3">
                    <label for="provision_text_after" class="form-label">Provision Text After</label>
                    <textarea class="form-control @error('provision_text_after') is-invalid @enderror" name="provision_text_after" id="provision_text_after" placeholder="Provision Text After" required>{{ old('provision_text_after') }}</textarea>
                    @error('provision_text_after')
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
