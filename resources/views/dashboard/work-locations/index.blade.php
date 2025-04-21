@extends('dashboard.layouts.main')

@section('content')
    <div class="card">
        <h5 class="card-header">Work Location List</h5>
        <div class="card-body">
            <a href="/dashboard/work-locations/create" class="btn btn-primary mb-4">Create New Location</a>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th style="width: 1px;">No</th>
                        <th>Location</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($workLocations->count())
                        @foreach ($workLocations as $location)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $location->location }}</td>
                                <td>
                                    <a href="/dashboard/work-locations/{{ $location->id }}/edit" class="btn btn-warning rounded-pill">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                    <form action="/dashboard/work-locations/{{ $location->id }}" method="post" class="d-inline">
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
                            <td colspan="3">No data found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection 