@extends('dashboard.layouts.main')

@section('content')
<div class="card">
    <h5 class="card-header">Daftar Pemohon</h5>
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th style="width: 1px;">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Vendor</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @if ($applicants->count()) @foreach ($applicants as $applicant)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $applicant->user->name }}</td>
                    <td>{{ $applicant->user->email }}</td>
                    <td>{{ $applicant->vendor->name }}</td>
                    <td>
                        <a href="{{ route('dashboard.applicants.index') }}/{{ $applicant->id }}" class="btn btn-primary rounded-pill">
                            <i class="bx bx-show"></i>
                        </a>
                    </td>
                </tr>
                @endforeach @else
                <tr>
                    <td colspan="5">Tidak ada data</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
@endpush