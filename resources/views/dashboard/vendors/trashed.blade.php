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
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th style="width: 1px;">No</th>
                        <th>Nama Legal</th>
                        <th>Nama Brand</th>
                        <th>Email</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($vendors->count())
                        @foreach ($vendors as $vendor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $vendor->legal_name }}</td>
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->email }}</td>
                                <td>
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
                    @else
                        <tr>
                            <td colspan="5">Tidak ada data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection 