@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Tembusan</h5>
        <div class="card-body">
            @if (in_array('dashboard_copies_create', $userPermissions))
                <button class="btn btn-primary mb-4 btn-add" data-bs-toggle="modal" data-bs-target="#copyModal">Tambah Data</button>
            @endif
            <table class="table table-bordered text-center data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 1px;">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Notifikasi</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($copies as $copy)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $copy->name }}</td>
                            <td class="text-center">{{ $copy->email ?? '-' }}</td>
                            <td class="text-center">{{ $copy->send_email ? '✅' : '❌' }}</td>
                            <td class="text-center text-nowrap">
                                @if (in_array('dashboard_copies_edit', $userPermissions))
                                    <button type="button" class="btn btn-warning rounded-pill btn-edit"
                                        data-copy='{
                                        "id":{{ $copy->id }},
                                        "name":"{{ $copy->name }}",
                                        "email":"{{ $copy->email }}",
                                        "sendEmail":{{ $copy->send_email }}
                                    }'>
                                        <i class="bx bx-edit-alt"></i>
                                    </button>
                                @endif
                                @if (in_array('dashboard_copies_delete', $userPermissions))
                                    <form action="{{ route('dashboard.copies.index') }}/{{ $copy->id }}" method="post"
                                        class="d-inline">
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

    @if (in_array('dashboard_copies_create', $userPermissions))
        <div class="modal fade" id="copyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="copyModalLabel"></h1>
                    </div>
                    <form id="modalForm" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" name="send_email" type="checkbox" id="send_email" />
                                <label class="form-check-label" for="send_email">Notifikasi</label>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nama" value="{{ old('name') }}" required autofocus autocomplete="off">
                                @error('name')
                                    <div class="invalid-feedback text-start">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="off">
                                @error('email')
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
    @endif
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
            $('#modalForm').attr('action', `/dashboard/copies`)
            $('.modal-title').text('Tambah Tembusan')

            $('[name="send_email"]').prop('checked', true)

            $('[name="name"]').val('')
            $('[name="email"]').val('')
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault()
            $('#modalForm').prepend('<input name="_method" type="hidden">')
            $('#modalForm [name="_method"]').val('put')

            let data = JSON.parse($(this).attr('data-copy'))

            $('.modal-title').text('Edit Tembusan')
            $('#modalForm').attr('action', `/dashboard/copies/${data.id}`)

            $('[name="send_email"]').prop('checked', data.sendEmail)

            $('[name="name"]').val(data.name)
            $('[name="email"]').val(data.email)

            $('#copyModal').modal('show')
        })

        $('#copyModal').on('hidden.bs.modal', function(e) {
            e.preventDefault()
            $('input[name="_method"][value="put"]').remove()
        })
    </script>
@endpush
