@extends('dashboard.layouts.main')

@section('content')
  <div class="card">
      <h5 class="card-header">Work Type List</h5>
      <div class="card-body">
          <a href="/dashboard/work-types/create" class="btn btn-primary mb-4">Create New Work Type</a>
          <table class="table table-bordered text-center">
              <thead>
                  <tr>
                      <th style="width: 1px;">No</th>
                      <th>Type</th>
                      <th>#</th>
                  </tr>
              </thead>
              <tbody>
                  @if ($workTypes->count())
                    @foreach ($workTypes as $type)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $type->type }}</td>
                            <td>
                                <a href="/dashboard/work-types/{{ $type->id }}/edit" class="btn btn-warning rounded-pill">
                                    <i class="bx bx-edit-alt"></i>
                                </a>
                                <form action="/dashboard/work-types/{{ $type->id }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-delete rounded-pill">
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
