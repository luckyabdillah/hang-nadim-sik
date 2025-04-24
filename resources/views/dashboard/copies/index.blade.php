@extends('dashboard.layouts.main')

@section('content')
  <div class="card">
      <h5 class="card-header">Daftar Tembusan</h5>
      <div class="card-body">
          <a href="{{ route('dashboard.copies.create') }}" class="btn btn-primary mb-4">Tambah Data</a>
          <table class="table table-bordered text-center">
              <thead>
                  <tr>
                      <th style="width: 1px;">No</th>
                      <th>Nama</th>
                      <th>#</th>
                  </tr>
              </thead>
              <tbody>
                  @if ($copies->count()) @foreach ($copies as $copy)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $copy->name }}</td>
                      <td>
                          <a href="{{ route('dashboard.copies.index') }}/{{ $copy->id }}/edit" class="btn btn-warning rounded-pill">
                              <i class="bx bx-edit-alt"></i>
                          </a>
                          <form action="{{ route('dashboard.copies.index') }}/{{ $copy->id }}" method="post" class="d-inline">
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
                      <td colspan="3">Tidak ada data</td>
                  </tr>
                  @endif
              </tbody>
          </table>
      </div>
  </div>
@endsection
