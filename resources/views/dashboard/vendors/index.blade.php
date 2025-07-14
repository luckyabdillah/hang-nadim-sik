@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Vendor</h5>
        <div class="card-body">
            <table class="table table-bordered text-center data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 1px;">No</th>
                        <th class="text-center">Nama Legal</th>
                        <th class="text-center">Nama Brand</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $vendor->legal_name }}</td>
                            <td class="text-center">{{ $vendor->user->name }}</td>
                            <td class="text-center">{{ $vendor->user->email }}</td>
                            <td class="text-center text-nowrap">
                                @if (in_array('dashboard_vendors_edit', $userPermissions))
                                    <a href="{{ route('dashboard.vendors.index') }}/{{ $vendor->uuid }}/edit" class="btn btn-warning rounded-pill">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                @endif
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