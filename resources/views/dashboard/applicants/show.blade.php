@extends('dashboard.layouts.main')

@section('content')
    <div class="card mb-3">
        <h5 class="card-header">Detail Pemohon</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.applicants.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" value="{{ $applicant->user->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" value="{{ $applicant->user->email }}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Detail Vendor</h5>
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" value="{{ $applicant->vendor->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" value="{{ $applicant->vendor->email ?? '-' }}" readonly>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" readonly>{{ $applicant->vendor->address ?? '-' }}</textarea>
                </div>
            </div>
        </div>
    </div>
@endsection
