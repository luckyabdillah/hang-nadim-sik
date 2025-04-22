@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Vendor List</h5>
        <div class="card-body">
            <a href="/dashboard/vendors/create" class="btn btn-primary mb-4">Create New Vendor</a>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th style="width: 1px;">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
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
                                    <a href="/dashboard/vendors/{{ $vendor->uuid }}/edit" class="btn btn-warning rounded-pill">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                    <form action="/dashboard/vendors/{{ $vendor->uuid }}" method="post" class="d-inline">
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
                            <td colspan="5">No data found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection 