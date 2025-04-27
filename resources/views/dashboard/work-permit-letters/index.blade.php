@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar SIK</h5>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th style="width: 1px;">No</th>
                        <th>Vendor</th>
                        <th>Tipe Pekerjaan</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($letters->count())
                        @foreach ($letters as $letter)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $letter->vendor->name }}</td>
                                <td>{{ $letter->workType->type }}</td>
                                <td>{{ $letter->workLocation->location }}</td>
                                <td>
                                    @if ($letter->status == 'submitted')
                                        <span class="badge bg-danger rounded-pill px-3">Menunggu Verifikasi</span>
                                    @elseif ($letter->status == 'verified')
                                        <span class="badge bg-warning rounded-pill px-3">Menunggu Persetujuan</span>
                                    @elseif ($letter->status == 'approved')
                                        <span class="badge bg-success rounded-pill px-3">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.work-permit-letters.index') }}/{{ $letter->uuid }}" class="btn btn-primary rounded-pill">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">Tidak ada data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection 