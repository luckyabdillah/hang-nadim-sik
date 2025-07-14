@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Dasar Surat</h5>
        <div class="card-body">
            @if (in_array('dashboard_letter-fundamentals_create', $userPermissions))
                <a href="{{ route('dashboard.letter-fundamentals.create') }}" class="btn btn-primary mb-4">Tambah Data</a>
            @endif
            <table class="table table-bordered text-center data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 1px;">No</th>
                        <th class="text-center">Referensi</th>
                        <th class="text-center">Posisi</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fundamentals as $fundamental)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $fundamental->reference }}</td>
                            <td class="text-center">{{ $fundamental->position }}</td>
                            <td class="text-center text-nowrap">
                                @if (in_array('dashboard_letter-fundamentals_edit', $userPermissions))
                                    <a href="{{ route('dashboard.letter-fundamentals.index') }}/{{ $fundamental->id }}/edit"
                                        class="btn btn-warning rounded-pill">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                @endif
                                @if (in_array('dashboard_letter-fundamentals_delete', $userPermissions))
                                    <form action="{{ route('dashboard.letter-fundamentals.index') }}/{{ $fundamental->id }}"
                                        method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-delete rounded-pill">
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
