@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Ubah Approver</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.approvers.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <form action="{{ route('dashboard.approvers.index') }}/{{ $approver->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" class="form-check-input" role="switch" name="is_default_approver" id="is_default_approver" {{ old('is_default_approver', $approver->is_default_approver) === null ? 'checked' : (old('is_default_approver', $approver->is_default_approver) == true ? 'checked' : '') }}>
                    <label for="is_default_approver" class="form-check-label">Default Approver</label>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nama" value="{{ old('name', $approver->user->name) }}" required autofocus autocomplete="off">
                        @error('name')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email', $approver->user->email) }}" required autocomplete="off">
                        @error('email')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-8">
                        <label for="position" class="form-label">Posisi</label>
                        <input type="text" class="form-control @error('position') is-invalid @enderror" name="position" id="position" placeholder="Posisi" value="{{ old('position', $approver->position) }}" required autocomplete="off">
                        @error('position')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="level" class="form-label">Level</label>
                        <input type="number" min="1" step="1" class="form-control @error('level') is-invalid @enderror" name="level" id="level" placeholder="Level" value="{{ old('level', $approver->level) }}" required autocomplete="off">
                        @error('level')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    {{-- <div class="col-12">
                        <label for="signature" class="form-label">Tanda Tangan</label>
                        <input type="file" class="form-control @error('signature') is-invalid @enderror" name="signature" id="signature" accept="image/*">
                        @error('signature')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}
                </div>
                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
