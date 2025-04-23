@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Ubah Tembusan</h5>
        <div class="card-body">
            <a href="/dashboard/copies" class="btn btn-secondary mb-3">Kembali</a>
            <form action="/dashboard/copies/{{ $copy->id }}" method="POST">
                @csrf
                @method('put')
                <div class="mb-4">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nama" value="{{ old('name', $copy->name) }}" required autofocus>
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
