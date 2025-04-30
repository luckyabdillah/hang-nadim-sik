@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Vendor Terhapus</h5>
        <div class="card-body">
            <div class="mb-4">
                <a href="{{ route('dashboard.vendors.index') }}" class="btn btn-secondary">Kembali</a>
                <form action="{{ route('dashboard.vendors.recoverAll') }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-restore">
                        Restore Semua
                    </button>
                </form>
            </div>
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
                            <td class="text-center">{{ $vendor->name }}</td>
                            <td class="text-center">{{ $vendor->email }}</td>
                            <td class="text-center text-nowrap">
                                <form action="{{ route('dashboard.vendors.recover', $vendor->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-warning rounded-pill btn-restore">
                                        <i class="bx bx-reset"></i>
                                    </button>
                                </form>
                                <form action="{{ route('dashboard.vendors.forceDelete', $vendor->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger rounded-pill btn-force-delete">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
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