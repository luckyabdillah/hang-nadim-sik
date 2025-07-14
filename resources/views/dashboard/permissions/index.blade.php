@extends('dashboard.layouts.main')

@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Hak Akses</h5>
        <div class="card-body">
            @if (in_array('dashboard_permissions_create', $userPermissions))
                <div class="mb-3">
                    <button class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#permissionModal">Tambah Hak Akses</button>
                </div>
            @endif
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th style="width: 1px;" class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Group</th>
                            <th class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $permission->name }}</td>
                                <td class="text-center">{{ $permission->group }}</td>
                                <td class="text-center">
                                    @if (in_array('dashboard_permissions_edit', $userPermissions))
                                        <button
                                            class="btn btn-warning badge rounded-pill px-3 btn-edit"
                                            data-permission='{
                                                "id":{{ $permission->id }},
                                                "name":"{{ $permission->name }}",
                                                "group":"{{ $permission->group }}"
                                            }'
                                        >
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                    @endif
                                    @if (in_array('dashboard_permissions_delete', $userPermissions))
                                        <form action="/dashboard/user-management/permissions/{{ $permission->id }}" method="post" class="d-inline">
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

    <!-- Permission Modal -->
    <div class="modal fade" id="permissionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="permissionModalLabel"></h1>
                </div>
                <form method="post" id="modalForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" autocomplete="off" placeholder="e.g. users_view / exchange_view" required>
                            @error('name')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="group" class="form-label">Group</label>
                            <input type="text" name="group" id="group" class="form-control @error('group') is-invalid @enderror" autocomplete="off" placeholder="Group" required>
                            @error('group')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                    </div>
                </form>
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

        $(document).on('click', '.btn-add', function(e) {
            e.preventDefault()
            $('#modalForm').attr('action', `/dashboard/user-management/permissions`)
            $('.modal-title').text('Tambah Hak Akses')

            $('[name="name"]').val('')
            $('[name="group"]').val('')
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault()
            $('#modalForm').prepend('<input name="_method" type="hidden">')
            $('#modalForm [name="_method"]').val('put')

            const data = JSON.parse($(this).attr('data-permission'))

            $('.modal-title').text('Edit Hak Akses')
            $('#modalForm').attr('action', `/dashboard/user-management/permissions/${data.id}`)

            $('[name="name"]').val(data.name)
            $('[name="group"]').val(data.group)

            $('#permissionModal').modal('show')
        })

        $('#permissionModal').on('hidden.bs.modal', function(e) {
            e.preventDefault()
            $('input[name="_method"][value="put"]').remove()
        })
    </script>
@endpush