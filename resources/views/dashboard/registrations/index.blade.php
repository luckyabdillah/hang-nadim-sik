@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Permohonan Registrasi</h5>
        <div class="card-body">
            <table class="table table-bordered text-center data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 1px;">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Vendor</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registrations as $registration)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $registration->name }}</td>
                            <td class="text-center">{{ $registration->vendor_name }}</td>
                            <td class="text-center">{{ $registration->email }}</td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('dashboard.registrations.index') }}/{{ $registration->uuid }}/edit" class="btn btn-primary rounded-pill">
                                    <i class="bx bx-show"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatable-bootstrap5-2.0.1.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/datatable/datatable-2.0.1.min.js') }}"></script>
    <script>
        $('.data-table').DataTable({
            autoWidth: false,
            initComplete: function() {
                $(this.api().table().container()).find('input').attr('autocomplete', 'off')
            },
        })
    </script>
@endpush