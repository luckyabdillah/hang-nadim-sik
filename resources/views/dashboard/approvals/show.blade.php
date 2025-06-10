@extends('dashboard.layouts.main')

@section('content')
    <div class="card mb-3">
        <h5 class="card-header">Detail SIK</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.approvals.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <p class="mb-2">
                Status:
                @if ($stage->workPermitLetter->status == 'submitted')
                    <span class="fw-bold text-danger">Menunggu Verifikasi</span>
                @elseif ($stage->workPermitLetter->status == 'verified')
                    <span class="fw-bold text-warning">Menunggu Persetujuan</span>
                @elseif ($stage->workPermitLetter->status == 'approved')
                    <span class="fw-bold text-success">Disetujui</span>
                @else
                    <span class="fw-bold text-danger">Ditolak</span>
                @endif
            </p>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label">Vendor</label>
                    <input type="text" class="form-control" value="{{ $stage->workPermitLetter->vendor->legal_name }} ({{ $stage->workPermitLetter->vendor->name }})" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lokasi Pekerjaan</label>
                    @if ($stage->workPermitLetter->workLocation->description)
                        <input type="text" class="form-control" value="{{ $stage->workPermitLetter->workLocation->location }} ({{ $stage->workPermitLetter->workLocation->description }})" readonly>
                    @else
                        <input type="text" class="form-control" value="{{ $stage->workPermitLetter->workLocation->location }}" readonly>
                    @endif
                </div>
                <div class="col-md-4 col-6">
                    <label class="form-label">Tipe Pekerjaan</label>
                    <input type="text" class="form-control" value="{{ $stage->workPermitLetter->workType->type }}" readonly>
                </div>
                <div class="col-md-4 col-6">
                    <label class="form-label">Tanggal Pengajuan</label>
                    <input type="text" class="form-control" value="{{ date('d/m/Y, H:i', strtotime($stage->workPermitLetter->created_at)) }}" readonly>
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" value="{{ $stage->workPermitLetter->description }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="text" class="form-control" value="{{ date('d/m/Y', strtotime($stage->workPermitLetter->started_at)) }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="text" class="form-control" value="{{ date('d/m/Y', strtotime($stage->workPermitLetter->ended_at)) }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">PIC Eksternal</label>
                    <input type="text" class="form-control" value="{{ $stage->workPermitLetter->external_pic_name }} &nbsp;|&nbsp; {{ $stage->workPermitLetter->external_pic_number }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">PIC Internal</label>
                    @if ($stage->workPermitLetter->internal_pic_name)
                        <input type="text" class="form-control" value="{{ $stage->workPermitLetter->internal_pic_name }} &nbsp;|&nbsp; {{ $stage->workPermitLetter->internal_pic_number }}" readonly>
                    @else
                        <input type="text" class="form-control" value="-" readonly>
                    @endif
                </div>
                @if ($stage->workPermitLetter->notes)
                    <div class="col-12">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" readonly>{{ $stage->workPermitLetter->notes }}</textarea>
                    </div>
                @endif
            </div>
            @if ($stage->workPermitLetter->status == 'approved')
                <a href="{{ route('dashboard.work-permit-letters.index') }}/{{ $stage->workPermitLetter->uuid }}/export-pdf" target="_blank" class="btn btn-primary">Download PDF</a>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#qrCodeModal">Show QR Code</button>
            @else
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applicationLetterModal">Surat Permohonan</button>
                @if ($stage->workPermitLetter->job_safety_analysis_document)
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#jsaDocumentModal">Dokumen JSA</button>
                @endif
            @endif
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Persetujuan</h5>
        <div class="card-body">
            @if ($stage->workPermitLetter->status == 'approved')
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input type="text" class="form-control" value="Disetujui" readonly>
                </div>
            @else
                <form action="{{ route('dashboard.approvals.index') }}/{{ $stage->id }}" method="post">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">-- Pilih status persetujuan --</option>
                            <option value="approved" {{ old('status', $stage->status) == 'approved' ? 'selected' : '' }}>Setuju</option>
                            <option value="rejected" {{ old('status', $stage->status) == 'rejected' ? 'selected' : '' }}>Tolak</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 d-none">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror " id="notes" name="notes" placeholder="Catatan" autocomplete="off">{{ old('notes', $stage->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-primary btn-submit">Submit</button>
                </form>
            @endif
        </div>
    </div>

    @if ($stage->workPermitLetter->status == 'approved')
        <!-- QR Code Modal -->
        <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="qrCodeModalLabel">QR Code</h1>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset("storage/") . '/' . $stage->workPermitLetter->qr_code }}" class="img-fluid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <a download="{{ str_replace('/', '-', $stage->workPermitLetter->letter_number) . '.png' }}" href="{{ asset("storage") . '/' . $stage->workPermitLetter->qr_code }}" class="btn btn-primary">Download</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Application Letter Modal -->
        <div class="modal fade" id="applicationLetterModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="applicationLetterModalLabel">Surat Permohonan</h1>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <embed src="{{ asset("storage") . '/' . $stage->workPermitLetter->application_letter }}" type="application/pdf" width="100%" height="500px">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        @if ($stage->workPermitLetter->job_safety_analysis_document)
            <!-- Job Safety Analysis Modal -->
            <div class="modal fade" id="jsaDocumentModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="jsaDocumentModalLabel">Dokumen JSA (Job Safety Analysis)</h1>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <embed src="{{ asset("storage") . '/' . $stage->workPermitLetter->job_safety_analysis_document }}" type="application/pdf" width="100%" height="500px">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', e => {
            const status = document.querySelector('#status')
            const notes = document.querySelector('#notes')
            if (status.value == 'rejected') {
                notes.parentElement.classList.remove('d-none')
                notes.setAttribute('required', true)
            }

            status.addEventListener('change', ev => {
                if (ev.target.value == 'rejected') {
                    notes.parentElement.classList.remove('d-none')
                    notes.setAttribute('required', true)
                } else {
                    notes.parentElement.classList.add('d-none')
                    notes.removeAttribute('required', true)
                }
            })
        })
    </script>
@endpush
