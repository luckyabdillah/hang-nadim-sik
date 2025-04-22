@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Edit Vendor</h5>
        <div class="card-body">
            <a href="/dashboard/vendors" class="btn btn-secondary mb-3">Back</a>
            <form action="/dashboard/vendors/{{ $vendor->uuid }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="name" class="form-label">Vendor Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name" value="{{ old('name', $vendor->name) }}" placeholder="Vendors Name" required autofocus>
                    @error('name')
                        <div class="invalid-feedback text-start">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror " id="email" name="email" value="{{ old('email', $vendor->email) }}" placeholder="Vendors Email">
                    @error('email')
                        <div class="invalid-feedback text-start">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror " id="address" name="address" placeholder="Vendors Address">{{ old('address', $vendor->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback text-start">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection 