@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Lokasi Pekerjaan</h5>
        <div class="card-body">
            @if (in_array('dashboard_work-locations_create', $userPermissions))
                <a href="{{ route('dashboard.work-locations.create') }}" class="btn btn-primary mb-4">Tambah Data</a>
            @endif
            <a href="{{ route('dashboard.work-locations.trashed') }}" class="btn btn-secondary mb-4">Recycle Bin</a>
            <table class="table table-bordered text-center data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 1px;">No</th>
                        <th class="text-center">Lokasi</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workLocations as $location)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $location->location }}</td>
                            <td class="text-center">{{ $location->description }}</td>
                            <td class="text-center text-nowrap">
                                @if (in_array('dashboard_work-locations_edit', $userPermissions))
                                    <a href="{{ route('dashboard.work-locations.index') }}/{{ $location->id }}/edit" class="btn btn-warning rounded-pill">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                @endif
                                @if (in_array('dashboard_work-locations_delete', $userPermissions))
                                    <form action="{{ route('dashboard.work-locations.index') }}/{{ $location->id }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger rounded-pill btn-delete">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
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