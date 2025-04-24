@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Ubah Vendor</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.vendors.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <form action="{{ route('dashboard.vendors.index') }}/{{ $vendor->uuid }}" method="post">
                @csrf
                @method('put')
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Vendor</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name" value="{{ old('name', $vendor->name) }}" placeholder="Nama Vendor" required autofocus>
                        @error('name')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror " id="email" name="email" value="{{ old('email', $vendor->email) }}" placeholder="Email">
                        @error('email')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror " id="address" name="address" placeholder="Alamat">{{ old('address', $vendor->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary btn-submit">Submit</button>
            </form>
        </div>
    </div>
@endsection 