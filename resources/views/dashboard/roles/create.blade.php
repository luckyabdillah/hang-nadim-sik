@extends('dashboard.layouts.main')

@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Tambah Role</h5>
        <div class="card-body">
            <div class="mb-3">
                <a href="/dashboard/user-management/roles" class="btn btn-secondary">Kembali</a>
            </div>
            <form action="/dashboard/user-management/roles" method="post">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" maxlength="50" placeholder="Nama" value="{{ old('title') }}" autocomplete="off" required/>
                    @error('title')
                        <div class="invalid-feedback text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <h6 class="text-uppercase mt-4">Hak Akses</h6>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="check_all" id="check_all">
                    <label class="form-check-label" for="check_all">
                        Centang Semua
                    </label>
                </div>
                @foreach ($permissions as $group => $groupPermissions)
                    <div class="mb-3">
                        <span class="form-label d-block">{{ $group }}</span>
                        <div class="mb-3">
                            @foreach ($groupPermissions as $permission)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input permissions" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}">
                                    <label class="form-check-label" for="permission{{ $permission->id }}">
                                        @php
                                            $explodedPermission = explode('_', $permission->name);
                                        @endphp
                                        {{ ucwords(end($explodedPermission)) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        document.querySelector('#check_all').addEventListener('click', e => {
            const permissions = document.querySelectorAll('.permissions')
            if (e.target.checked) {
                permissions.forEach(checkbox => {
                    checkbox.checked = true
                })
            } else {
                permissions.forEach(checkbox => {
                    checkbox.checked = false
                })
            }
        })
    </script>
@endpush