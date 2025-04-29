@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Tambah Dasar Surat</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.letter-fundamentals.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <form action="{{ route('dashboard.letter-fundamentals.index') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="reference" class="form-label">Referensi</label>
                    <input type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" id="reference" placeholder="Referensi" value="{{ old('reference') }}" required autofocus autocomplete="off">
                    @error('reference')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="position" class="form-label">Posisi</label>
                    <input type="number" min="1" step="1" class="form-control @error('position') is-invalid @enderror" name="position" id="position" placeholder="Posisi" value="{{ old('position', $totalFundamental + 1) }}" required autocomplete="off">
                    @error('position')
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
