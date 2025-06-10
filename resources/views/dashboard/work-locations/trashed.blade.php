@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Lokasi Pekerjaan Terhapus</h5>
        <div class="card-body">
            <div class="mb-4">
                <a href="{{ route('dashboard.work-locations.index') }}" class="btn btn-secondary">Kembali</a>
                <form action="{{ route('dashboard.work-locations.recoverAll') }}" method="post" class="d-inline">
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
                                <form action="{{ route('dashboard.work-locations.recover', $location->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-warning rounded-pill btn-restore">
                                        <i class="bx bx-reset"></i>
                                    </button>
                                </form>
                                <form action="{{ route('dashboard.work-locations.forceDelete', $location->id) }}" method="post" class="d-inline">
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