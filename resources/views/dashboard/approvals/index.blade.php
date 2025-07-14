@extends('dashboard.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/theme/libs/datepicker/daterangepicker.css') }}">
@endpush

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Persetujuan</h5>
        <div class="card-body">
            <form>
                <div class="row g-3 justify-content-end mb-4">
                    <div class="col-md-5">
                        <input type="text" name="date" id="date" class="form-control datepicker" value="{{ request('date') }}" placeholder="Rentang waktu" autocomplete="off">
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Filter berdasarkan nama vendor atau nomor surat" autocomplete="off">
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th style="width: 1px;">No</th>
                        <th>No Surat</th>
                        <th>Vendor</th>
                        <th>Status</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($stages->count())
                        @foreach ($stages as $stage)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $stage->workPermitLetter->letter_number }}</td>
                                <td>{{ $stage->workPermitLetter->vendor->legal_name }}</td>
                                <td>
                                    @if ($stage->status == 'pending')
                                        <span class="badge bg-danger rounded-pill px-3">Pending</span>
                                    @elseif ($stage->status == 'waiting')
                                        <span class="badge bg-warning rounded-pill px-3">Menunggu Persetujuan</span>
                                    @elseif ($stage->status == 'approved')
                                        <span class="badge bg-success rounded-pill px-3">Disetujui</span>
                                    @elseif ($letter->status == 'finished')
                                        <span class="badge bg-success rounded-pill px-3">Selesai</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.approvals.index') }}/{{ $stage->id }}" class="btn btn-primary rounded-pill">
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
            <div class="mt-3">
                {{ $stages->links() }}
            </div>
        </div>
    </div>
@endsection 

@push('scripts')
    <script src="{{ asset('assets/theme/libs/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/theme/libs/datepicker/daterangepicker.min.js') }}"></script>
    <script>
        const now = new Date()
        const current = new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(now)
        
        const startDate = @json($dateRangeStart);
        const endDate = @json($dateRangeEnd);

        $('.datepicker').daterangepicker({
            autoApply: true,
            showDropdowns: true,
            minYear: 2020,
            startDate: startDate,
            endDate: endDate,
            maxDate: current,
            locale: {
                "format": "DD/MM/YYYY",
                "daysOfWeek": [
                    "Min",
                    "Sen",
                    "Sel",
                    "Rab",
                    "Kam",
                    "Jum",
                    "Sab"
                ],
                "monthNames": [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember"
                ],
            }
        })
    </script>
@endpush