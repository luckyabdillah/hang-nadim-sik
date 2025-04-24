@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Vendor</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.vendors.create') }}" class="btn btn-primary mb-4">Tambah Data</a>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th style="width: 1px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($vendors->count())
                        @foreach ($vendors as $vendor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->email ?? '-' }}</td>
                                <td>{{ $vendor->address ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('dashboard.vendors.index') }}/{{ $vendor->uuid }}/edit" class="btn btn-warning rounded-pill">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                    <form action="{{ route('dashboard.vendors.index') }}/{{ $vendor->uuid }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger rounded-pill btn-delete">
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