@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Lokasi Pekerjaan</h5>
        <div class="card-body">
            <a href="{{ route('dashboard.work-locations.create') }}" class="btn btn-primary mb-4">Tambah Data</a>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th style="width: 1px;">No</th>
                        <th>Lokasi</th>
                        <th>Deskripsi</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($workLocations->count())
                        @foreach ($workLocations as $location)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $location->location }}</td>
                                <td>{{ $location->description }}</td>
                                <td>
                                    <a href="{{ route('dashboard.work-locations.index') }}/{{ $location->id }}/edit" class="btn btn-warning rounded-pill">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                    <form action="{{ route('dashboard.work-locations.index') }}/{{ $location->id }}" method="post" class="d-inline">
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
                            <td colspan="4">Tidak ada data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection 