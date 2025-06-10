@extends('dashboard.layouts.main')

@section('content')
    <div class="card mb-3">
        <h5 class="card-header">Permohonan Registrasi</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.registrations.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" value="{{ $registration->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Vendor</label>
                    <input type="text" class="form-control" value="{{ $registration->vendor_name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" value="{{ $registration->email }}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Persetujuan</h5>
        <div class="card-body">
            <form action="{{ route('dashboard.registrations.index') }}/{{ $registration->uuid }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="vendor_id" class="form-label">Pilih Vendor</label>
                    <select type="text" class="form-select @error('vendor_id') is-invalid @enderror" id="vendor_id" name="vendor_id">
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id', $vendorPossibility) == $vendor->id ? 'selected' : '' }}>{{ $vendor->legal_name }} ({{ $vendor->name }})</option>
                        @endforeach
                    </select>
                    @error('vendor_id')
                        <div class="invalid-feedback text-start">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary btn-submit">Submit</button>
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
        $('[name="vendor_id"]').select2({
            theme: 'bootstrap-5',
        })
    </script>
@endpush