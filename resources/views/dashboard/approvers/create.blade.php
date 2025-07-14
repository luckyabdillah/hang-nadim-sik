@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Tambah Approver</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.approvers.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <form action="{{ route('dashboard.approvers.index') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" class="form-check-input" role="switch" name="is_default_approver" id="is_default_approver" {{ old('is_default_approver') === null ? 'checked' : (old('is_default_approver') == true ? 'checked' : '') }}>
                    <label for="is_default_approver" class="form-check-label">Default Approver</label>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="user_id" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} &nbsp;|&nbsp; {{ $user->email }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-8">
                        <label for="position" class="form-label">Posisi</label>
                        <input type="text" class="form-control @error('position') is-invalid @enderror" name="position" id="position" placeholder="Posisi" value="{{ old('position') }}" required autocomplete="off">
                        @error('position')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="level" class="form-label">Level</label>
                        <input type="number" min="1" step="1" class="form-control @error('level') is-invalid @enderror" name="level" id="level" placeholder="Level" value="{{ old('level') }}" required autocomplete="off">
                        @error('level')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="signature" class="form-label">Tanda Tangan</label>
                        <input type="file" class="form-control @error('signature') is-invalid @enderror" name="signature" id="signature" accept="image/*" required>
                        @error('signature')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-4.1.0.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap-5-theme-1.3.0.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/select2-4.1.0.min.js') }}"></script>
    <script>
        $('[name="user_id"]').select2({
            theme: 'bootstrap-5',
        })
    </script>
@endpush
