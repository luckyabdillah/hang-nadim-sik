@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Tambah SIK</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.my.work-permit-letters.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <form action="{{ route('dashboard.my.work-permit-letters.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="date_diff">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="work_location_id" class="form-label">Lokasi Pekerjaan</label>
                        <select class="form-select @error('work_location_id') is-invalid @enderror" name="work_location_id" id="work_location_id" required>
                            @foreach ($workLocations as $location)
                                <option value="{{ $location->id }}" {{ old('work_location_id') == $location->id ? 'selected' : '' }}>{{ $location->location }} ({{ $location->description }})</option>
                            @endforeach
                            <option value="lainnya" data-other-location="true">Lainnya</option>
                        </select>
                        @error('work_location_id')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md other-location d-none">
                        <label for="other_location" class="form-label">Deskripsi Lokasi</label>
                        <input type="text" class="form-control @error('other_location') is-invalid @enderror" name="other_location" id="other_location" placeholder="Deskripsi" value="{{ old('other_location') }}" autocomplete="off">
                        @error('other_location')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md">
                        <label for="work_type_id" class="form-label">Tipe Pekerjaan</label>
                        <select class="form-select @error('work_type_id') is-invalid @enderror" name="work_type_id" id="work_type_id" required>
                            @foreach ($workTypes as $type)
                                <option value="{{ $type->id }}" {{ old('work_type_id') == $type->id ? 'selected' : '' }}>{{ $type->type }}</option>
                            @endforeach
                        </select>
                        @error('work_type_id')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="started_at" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control @error('started_at') is-invalid @enderror" name="started_at" id="started_at" min="{{ date('Y-m-d', strtotime('now')) }}" value="{{ old('started_at') }}" required>
                        @error('started_at')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="ended_at" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control @error('ended_at') is-invalid @enderror" name="ended_at" id="ended_at" min="{{ date('Y-m-d', strtotime('now')) }}" value="{{ old('ended_at') }}" required>
                        @error('ended_at')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="description" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Deskripsi" value="{{ old('description') }}" required autocomplete="off">
                        @error('description')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="external_pic_name" class="form-label">Nama PIC</label>
                        <input type="text" class="form-control @error('external_pic_name') is-invalid @enderror" name="external_pic_name" id="external_pic_name" placeholder="Nama PIC" value="{{ old('external_pic_name') }}" required autocomplete="off">
                        @error('external_pic_name')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="external_pic_number" class="form-label">Nomor PIC</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">+62</span>
                            <input type="text" class="form-control @error('external_pic_number') is-invalid @enderror" name="external_pic_number" id="external_pic_number" placeholder="8XXXXXXXXXX" value="{{ old('external_pic_number') }}" required autocomplete="off">
                        </div>
                        @error('external_pic_number')
                            <div class="invalid-feedback text-start d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md">
                        <label for="application_letter" class="form-label">Surat Permohonan</label>
                        <input type="file" accept="application/pdf" class="form-control @error('application_letter') is-invalid @enderror" name="application_letter" id="application_letter" value="{{ old('application_letter') }}" required>
                        @error('application_letter')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md airport-pass {{ old('date_diff') >= 3 ? '' : 'd-none' }}">
                        <label for="airport_pass" class="form-label">Pass Bandara</label>
                        <input type="file" accept="application/pdf" class="form-control @error('airport_pass') is-invalid @enderror" name="airport_pass" id="airport_pass" value="{{ old('airport_pass') }}" {{ old('date_diff') >= 3 ? 'required' : '' }}>
                        @error('airport_pass')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md">
                        <label for="job_safety_analysis_document" class="form-label">Dokumen JSA (Opsional)</label>
                        <input type="file" accept="application/pdf" class="form-control @error('job_safety_analysis_document') is-invalid @enderror" name="job_safety_analysis_document" id="job_safety_analysis_document" value="{{ old('job_safety_analysis_document') }}">
                        @error('job_safety_analysis_document')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="application_letter_number" class="form-label">No. Surat Permohonan</label>
                        <input type="text" class="form-control @error('application_letter_number') is-invalid @enderror" name="application_letter_number" id="application_letter_number" placeholder="No. Surat Permohonan" value="{{ old('application_letter_number') }}" required autocomplete="off">
                        @error('application_letter_number')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="application_letter_date" class="form-label">Tanggal Surat Permohonan</label>
                        <input type="date" class="form-control @error('application_letter_date') is-invalid @enderror" name="application_letter_date" id="application_letter_date" placeholder="Tanggal Surat Permohonan" value="{{ old('application_letter_date') }}" required autocomplete="off">
                        @error('application_letter_date')
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-4.1.0.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap-5-theme-1.3.0.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/select2-4.1.0.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const workLocation = $('[name="work_location_id"]').select2({
                theme: 'bootstrap-5',
            })
    
            const otherLocationContainer = document.querySelector('.other-location')
            const otherLocationInput = document.querySelector('[name="other_location"]')
    
            workLocation.on('change', e => {
                const selectedValue = $('#work_location_id').val()
                const originalOption = document.querySelector(`#work_location_id option[value="${selectedValue}"]`)
                const isOtherLocation = originalOption?.dataset.otherLocation == 'true'
    
                if (isOtherLocation) {
                    otherLocationContainer.classList.remove('d-none')
                    otherLocationInput.setAttribute('required', true)
                    setTimeout(() => {
                        otherLocationInput.focus()
                    }, 150);
                } else {
                    otherLocationContainer.classList.add('d-none')
                    otherLocationInput.removeAttribute('required')
                }
            })
    
            airportPassContainer = document.querySelector('.airport-pass')
            airportPassInput = document.querySelector('[name="airport_pass"]')
    
            const calculateDateDiff = () => {
                const startedAt = document.querySelector('[name="started_at"]').value
                const endedAt = document.querySelector('[name="ended_at"]').value
    
                if (!endedAt || !startedAt) return false
    
                const startDate = new Date(startedAt), endDate = new Date(endedAt)
    
                const diffTime = endDate - startDate
                const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24))
    
                document.querySelector('[name="date_diff"]').value = diffDays
                
                if (diffDays >= 3) {
                    airportPassContainer.classList.remove('d-none')
                    airportPassInput.setAttribute('required', true)
                } else {
                    airportPassContainer.classList.add('d-none')
                    airportPassInput.removeAttribute('required')
                }
            }
    
            document.querySelector('[name="started_at"]').addEventListener('input', e => {
                calculateDateDiff()
            })
    
            document.querySelector('[name="ended_at"]').addEventListener('input', e => {
                calculateDateDiff()
            })
        })
    </script>
@endpush
