@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Tambah Lokasi Pekerjaan</h5>
        <div class="card-body">
            <a href="/dashboard/work-locations" class="btn btn-secondary mb-3">Kembali</a>
            <form action="/dashboard/work-locations" method="post">
                @csrf
                <div class="mb-4">
                    <label for="location" class="form-label">Nama Lokasi</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror " id="location" name="location" value="{{ old('location') }}" placeholder="Nama Lokasi" required autofocus>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary btn-submit">Submit</button>
            </form>
        </div>
    </div>
@endsection 