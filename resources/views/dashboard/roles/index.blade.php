@extends('dashboard.layouts.main')

@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Role</h5>
        <div class="card-body">
            <div class="mb-3">
                @if (in_array('dashboard_roles_create', $userPermissions))
                    <a href="/dashboard/user-management/roles/create" class="btn btn-primary">Tambah Role</a>
                @endif
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th style="width: 1px;" class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Hak Akses</th>
                            <th class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $role->title }}</td>
                                <td class="text-wrap">
                                    @foreach ($role->permissions as $permission)
                                        <span class="badge bg-info text-lowercase mb-1">{{ $permission->name }}</span>
                                    @endforeach    
                                </td>
                                <td class="text-center">
                                    @if (in_array('dashboard_roles_edit', $userPermissions))
                                        <a href="/dashboard/user-management/roles/{{ $role->id }}/edit" class="btn btn-warning badge rounded-pill px-3">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                    @endif
                                    @if (in_array('dashboard_roles_delete', $userPermissions))
                                        <form action="/dashboard/user-management/roles/{{ $role->id }}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger badge rounded-pill px-3 btn-delete"><i class="bx bx-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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