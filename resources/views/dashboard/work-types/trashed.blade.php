@extends('dashboard.layouts.main')

@section('content')
  <div class="card">
      <h5 class="card-header">Daftar Tipe Pekerjaan Terhapus</h5>
      <div class="card-body">
        <div class="mb-4">
            <a href="{{ route('dashboard.work-types.index') }}" class="btn btn-secondary">Kembali</a>
            <form action="{{ route('dashboard.work-types.recoverAll') }}" method="post" class="d-inline">
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
                      <th>Tipe Pekerjaan</th>
                      <th>Nama Unit</th>
                      <th>#</th>
                  </tr>
              </thead>
              <tbody>
                  @if ($workTypes->count())
                    @foreach ($workTypes as $type)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $type->type }}</td>
                            <td>{{ $type->unit_name }}</td>
                            <td>
                                <form action="{{ route('dashboard.work-types.recover', $type->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-warning rounded-pill btn-restore">
                                        <i class="bx bx-reset"></i>
                                    </button>
                                </form>
                                <form action="{{ route('dashboard.work-types.forceDelete', $type->id) }}" method="post" class="d-inline">
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
                      <td colspan="4">Tidak ada data</td>
                  </tr>
                  @endif
              </tbody>
          </table>
      </div>
  </div>
@endsection
