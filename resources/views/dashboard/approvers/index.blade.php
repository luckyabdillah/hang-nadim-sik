@extends('dashboard.layouts.main')

@section('content')
<div class="card">
    <h5 class="card-header">Daftar Approver</h5>
    <div class="card-body">
        <a href="{{ route('dashboard.approvers.create') }}" class="btn btn-primary mb-4">Tambah Data</a>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th style="width: 1px;">No</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Level</th>
                    <th>Default</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @if ($approvers->count()) @foreach ($approvers as $approver)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $approver->user->name }}</td>
                    <td>{{ $approver->position }}</td>
                    <td>{{ $approver->level }}</td>
                    <td>{{ $approver->is_default_approver ? 'Ya' : 'Tidak' }}</td>
                    <td>
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
                @endforeach @else
                <tr>
                    <td colspan="6">Tidak ada data</td>
                </tr>
                @endif
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

@push('scripts')
    <script>
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

