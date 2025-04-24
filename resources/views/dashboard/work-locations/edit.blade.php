@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Edit Lokasi Pekerjaan</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.work-locations.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <form action="{{ route('dashboard.work-locations.index') }}/{{ $location->id }}" method="post">
                @csrf
                @method('put')
                <div class="mb-4">
                    <label for="location" class="form-label">Nama Lokasi</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror " id="location" name="location" value="{{ old('location', $location->location) }}" placeholder="Nama Lokasi" required autofocus>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary btn-submit">Submit</button>
            </form>
        </div>
    </div>
@endsection 