@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Ubah Tipe Pekerjaan</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.work-types.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <form action="{{ route('dashboard.work-types.index') }}/{{ $type->id }}" method="POST">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="type" class="form-label">Tipe Pekerjaan</label>
                    <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type" placeholder="Tipe Pekerjaan" value="{{ old('type', $type->type) }}" required autofocus autocomplete="off">
                    @error('type')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div> 
                <div class="mb-3">
                    <label for="provision_text_before" class="form-label">Ketentuan (Sebelum)</label>
                    <textarea class="form-control @error('provision_text_before') is-invalid @enderror" rows="3" name="provision_text_before" id="provision_text_before" placeholder="Ketentuan (Sebelum)" required autocomplete="off">{{ old('provision_text_before', $type->provision_text_before ) }}</textarea>
                    @error('provision_text_before')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div> 
                <div class="mb-4">
                    <label for="provision_text_after" class="form-label">Ketentuan (Setelah)</label>
                    <textarea class="form-control @error('provision_text_after') is-invalid @enderror" rows="3" name="provision_text_after" id="provision_text_after" placeholder="Ketentuan (Setelah)" required autocomplete="off">{{ old('provision_text_after', $type->provision_text_after) }}</textarea>
                    @error('provision_text_after')
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
