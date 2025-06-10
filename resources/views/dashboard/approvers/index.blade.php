@extends('dashboard.layouts.main')

@section('content')
<div class="card">
    <h5 class="card-header">Daftar Approver</h5>
    <div class="card-body">
        <a href="{{ route('dashboard.approvers.create') }}" class="btn btn-primary mb-4">Tambah Data</a>
        <table class="table table-bordered text-center data-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 1px;">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Posisi</th>
                    <th class="text-center">Level</th>
                    <th class="text-center">Default</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($approvers as $approver)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $approver->user->name }}</td>
                        <td class="text-center">{{ $approver->position }}</td>
                        <td class="text-center">{{ $approver->level }}</td>
                        <td class="text-center">{{ $approver->is_default_approver ? 'Ya' : 'Tidak' }}</td>
                        <td class="text-center text-nowrap">
                            <button
                                class="btn btn-secondary rounded-pill btn-signature"
                                data-is-signed="{{ $approver->signature ? 'true' : '' }}"
                                data-signature="{{ $approver->signature ? asset("storage/$approver->signature") : '' }}"
                            >
                                <i class="bx bx-pen"></i>
                            </button>
                            <a href="{{ route('dashboard.approvers.index') }}/{{ $approver->id }}/edit" class="btn btn-warning rounded-pill">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <form action="{{ route('dashboard.approvers.index') }}/{{ $approver->id }}" method="post" class="d-inline">
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

<!-- Signature Modal -->
<div class="modal fade" id="signatureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="signatureModalLabel">Tanda Tangan</h1>
            </div>
            <div class="modal-body">
                <div class="text-center signature">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
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

        $(document).on('click', '.btn-signature', function (e) {
            e.preventDefault()
            const isSigned = $(this).attr('data-is-signed')
            console.log(isSigned)
            let signature = 'Belum ada tanda tangan'
            if (isSigned) {
                const path = $(this).attr('data-signature')
                signature = `<img src="${path}" alt="Signature" class="img-fluid">`
            }
            $('.signature').html(signature)

            $('#signatureModal').modal('show')
        })
    </script>
@endpush