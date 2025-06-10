@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Ubah Tembusan</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.copies.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <form action="{{ route('dashboard.copies.index') }}/{{ $copy->id }}" method="POST">
                @csrf
                @method('put')
                <div class="mb-4">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nama" value="{{ old('name', $copy->name) }}" required autofocus autocomplete="off">
                    @error('name')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
