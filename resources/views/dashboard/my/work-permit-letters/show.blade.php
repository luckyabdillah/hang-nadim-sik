@extends('dashboard.layouts.main')

@section('content')
    <div class="card mb-3">
        <h5 class="card-header">Detail SIK</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.my.work-permit-letters.index') }}" class="btn btn-secondary mb-3">Kembali</a>
            <p class="mb-2">
                Status:
                @if ($letter->status == 'submitted')
                    <span class="fw-bold text-danger">Menunggu Verifikasi</span>
                @elseif ($letter->status == 'verified')
                    <span class="fw-bold text-warning">Menunggu Persetujuan</span>
                @elseif ($letter->status == 'approved')
                    <span class="fw-bold text-success">Disetujui</span>
                @else
                    <span class="fw-bold text-danger">Ditolak</span>
                @endif
            </p>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label">Vendor</label>
                    <input type="text" class="form-control" value="{{ $letter->vendor->legal_name }} ({{ $letter->vendor->name }})" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lokasi Pekerjaan</label>
                    @if ($letter->workLocation->description)
                        <input type="text" class="form-control" value="{{ $letter->workLocation->location }} ({{ $letter->workLocation->description }})" readonly>
                    @else
                        <input type="text" class="form-control" value="{{ $letter->workLocation->location }}" readonly>
                    @endif
                </div>
                <div class="col-md-4 col-6">
                    <label class="form-label">Tipe Pekerjaan</label>
                    <input type="text" class="form-control" value="{{ $letter->workType->type }}" readonly>
                </div>
                <div class="col-md-4 col-6">
                    <label class="form-label">Tanggal Pengajuan</label>
                    <input type="text" class="form-control" value="{{ date('d/m/Y, H:i', strtotime($letter->created_at)) }}" readonly>
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" value="{{ $letter->description }}" readonly>
                </div>
                <div class="col-6">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="text" class="form-control" value="{{ date('d/m/Y', strtotime($letter->started_at)) }}" readonly>
                </div>
                <div class="col-6">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="text" class="form-control" value="{{ date('d/m/Y', strtotime($letter->ended_at)) }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">PIC Eksternal</label>
                    <input type="text" class="form-control" value="{{ $letter->external_pic_name }} &nbsp;|&nbsp; {{ $letter->external_pic_number }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">PIC Internal</label>
                    @if ($letter->internal_pic_name)
                        <input type="text" class="form-control" value="{{ $letter->internal_pic_name }} &nbsp;|&nbsp; {{ $letter->internal_pic_number }}" readonly>
                    @else
                        <input type="text" class="form-control" value="-" readonly>
                    @endif
                </div>
                @if ($letter->notes)
                    <div class="col-12">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" readonly>{{ $letter->notes }}</textarea>
                    </div>
                @endif
            </div>
            @if ($letter->status == 'approved')
                <a href="{{ route('dashboard.work-permit-letters.index') }}/{{ $letter->uuid }}/export-pdf" target="_blank" class="btn btn-primary">Download PDF</a>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#qrCodeModal">Show QR Code</button>
            @else
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applicationLetterModal">Surat Permohonan</button>
                @if ($letter->job_safety_analysis_document)
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#jsaDocumentModal">Dokumen JSA</button>
                @endif
            @endif
        </div>
    </div>

    @if ($letter->status == 'approved')
        <!-- QR Code Modal -->
        <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="qrCodeModalLabel">QR Code</h1>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset("storage/$letter->qr_code") }}" class="img-fluid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <a download="{{ str_replace('/', '-', $letter->letter_number) . '.png' }}" href="{{ asset("storage/$letter->qr_code") }}" class="btn btn-primary">Download</a>
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
                            <embed src="{{ asset("storage/$letter->application_letter") }}" type="application/pdf" width="100%" height="500px">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        @if ($letter->job_safety_analysis_document)
            <!-- Job Safety Analysis Modal -->
            <div class="modal fade" id="jsaDocumentModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="jsaDocumentModalLabel">Dokumen JSA (Job Safety Analysis)</h1>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <embed src="{{ asset("storage/$letter->job_safety_analysis_document") }}" type="application/pdf" width="100%" height="500px">
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