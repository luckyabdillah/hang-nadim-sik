@extends('dashboard.layouts.main')

@section('content')
<div class="card">
    <h5 class="card-header">Daftar Pengguna</h5>
    <div class="card-body">
        <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary mb-4">Tambah Data</a>
        <table class="table table-bordered text-center data-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 1px;">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $user->name }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{ ucfirst($user->role) }}</td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('dashboard.users.index') }}/{{ $user->uuid }}/edit" class="btn btn-warning rounded-pill">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <form action="{{ route('dashboard.users.index') }}/{{ $user->uuid }}" method="post" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-delete rounded-pill">
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