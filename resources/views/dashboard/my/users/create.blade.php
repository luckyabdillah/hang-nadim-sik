@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Tambah Pengguna</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.my.users.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <form action="{{ route('dashboard.my.users.index') }}" method="POST">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nama" value="{{ old('name') }}" required autofocus autocomplete="off">
                        @error('name')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="off">
                        @error('email')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="********" required>
                        @error('password')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="********" required>
                        @error('password_confirmation')
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
