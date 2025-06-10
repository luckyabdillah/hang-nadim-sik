@extends('dashboard.layouts.main')

@section('content')
    <div class="card mb-3">
        <h5 class="card-header">Detail SIK</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.work-permit-letters.index') }}" class="btn btn-secondary mb-3">Kembali</a>
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
                <div class="col-md-6">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="text" class="form-control" value="{{ date('d/m/Y', strtotime($letter->started_at)) }}" readonly>
                </div>
                <div class="col-md-6">
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
    @if ($letter->status == 'submitted')
        <div class="card">
            <h5 class="card-header">Verifikasi</h5>
            <div class="card-body">
                <form action="{{ route('dashboard.work-permit-letters.index') }}/{{ $letter->uuid }}" method="post">
                    @csrf
                    @method('put')
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label for="approvers[]" class="form-label">Pemberi Persetujuan (Approver)</label>
                            <select class="form-select @error('approvers[]') is-invalid @enderror" id="approvers[]" name="approvers[]" multiple required>
                                @foreach ($approvers as $approver)
                                    <option value="{{ $approver->id }}" {{ old("approvers.$loop->index") == $approver->id ? 'selected' : ($approver->is_default_approver ? 'selected' : '') }}>{{ $approver->position }} (Level {{ $approver->level }})</option>
                                @endforeach
                            </select>
                            @error('approvers[]')
                                <div class="invalid-feedback text-start">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="letter_number" class="form-label">Nomor Surat</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">BTH.</span>
                                <input type="text" class="form-control @error('letter_number') is-invalid @enderror" id="letter_number" name="letter_number" value="{{ old('letter_number') }}" placeholder="Nomor Surat" required autocomplete="off">
                                <span class="input-group-text" id="basic-addon2">/SIK/BIB/{{ date('Y') }}-</span>
                                <input type="text" class="form-control @error('letter_number_end') is-invalid @enderror" id="letter_number_end" name="letter_number_end" value="{{ old('letter_number_end', $monthInAlpha) }}" placeholder="A-L" required autocomplete="off">
                            </div>
                            @error('letter_number')
                                <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="pointing" class="form-label">Tunjukan</label>
                            <textarea class="form-control @error('pointing') is-invalid @enderror" id="pointing" name="pointing" placeholder="Surat HR. Dept ... Nomor ... " autocomplete="off">{{ old('pointing') }}</textarea>
                            @error('pointing')
                                <div class="invalid-feedback text-start">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="internal_pic_name" class="form-label">Nama PIC Internal</label>
                            <input type="text" class="form-control @error('internal_pic_name') is-invalid @enderror" id="internal_pic_name" name="internal_pic_name" value="{{ old('internal_pic_name') }}" placeholder="Nama PIC Internal" required autocomplete="off">
                            @error('internal_pic_name')
                                <div class="invalid-feedback text-start">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="internal_pic_number" class="form-label">Nomor PIC Internal</label>
                            <input type="text" class="form-control @error('internal_pic_number') is-invalid @enderror" id="internal_pic_number" name="internal_pic_number" value="{{ old('internal_pic_number') }}" placeholder="Nomor PIC Internal" required autocomplete="off">
                            @error('internal_pic_number')
                                <div class="invalid-feedback text-start">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary btn-submit">Verifikasi</button>
                    <button type="button" class="btn btn-danger btn-cancel" data-bs-toggle="modal" data-bs-target="#rejectionModal">Tolak</button>
                </form>
            </div>
        </div>
    @else
        <div class="card">
            <h5 class="card-header">Tahap Persetujuan</h5>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th style="width: 1px;">Level</th>
                            <th>Posisi</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($stages->count())
                            @foreach ($stages as $stage)
                                <tr>
                                    <td>{{ $stage->level }}</td>
                                    <td>{{ $stage->position }}</td>
                                    <td>
                                        @if ($stage->status == 'pending')
                                            <span class="badge bg-danger rounded-pill px-3">Pending</span>
                                        @elseif ($stage->status == 'waiting')
                                            <span class="badge bg-warning rounded-pill px-3">Menunggu Persetujuan</span>
                                        @elseif ($stage->status == 'approved')
                                            <span class="badge bg-success rounded-pill px-3">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $stage->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">Tidak ada tahapan persetujuan</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif

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

    <!-- Rejection Modal -->
    <div class="modal fade" id="rejectionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('dashboard.work-permit-letters.index') }}/{{ $letter->uuid }}" method="post">
                @csrf
                @method('delete')
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="rejectionModalLabel">Penolakan SIK</h1>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" placeholder="Catatan" required autocomplete="off">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback text-start">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                    </div>
                </div>
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
        $('[name="approvers[]"]').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih approver',
        })
    </script>
@endpush
