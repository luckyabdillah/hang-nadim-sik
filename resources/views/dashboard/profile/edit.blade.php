@extends('dashboard.layouts.main')

@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Profile Details</h5>
        <form action="/dashboard/profile" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nama Lengkap" value="{{ old('name', $user->name) }}" autocomplete="off" required>
                        @error('name')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email', $user->email) }}" autocomplete="off" required>
                        @error('email')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                @if ($isExternal)
                    <div class="mb-3">
                        <label for="vendor_name" class="form-label">Nama Vendor</label>
                        <input type="text" class="form-control" name="vendor_name" id="vendor_name" placeholder="Nama Vendor" value="{{ $user->applicant->vendor->name }}" autocomplete="off" disabled>
                    </div>
                @else
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" name="role" id="role" placeholder="Role" value="{{ ucwords($user->role) }}" autocomplete="off" disabled>
                    </div>
                @endif
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-submit">Update</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card mb-4">
        <h5 class="card-header">Ubah Password</h5>
        <form method="post" action="/change-password">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="mb-3">
                    <label for="old_password" class="form-label">Password Lama</label>
                    <div class="input-group input-group-merge">
                        <input type="password" name="old_password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" autocomplete="off" placeholder="Password Lama" required>
                        <span class="input-group-text btn-show-password cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    @error('old_password')
                        <div class="invalid-feedback d-block text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <div class="input-group input-group-merge">
                        <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" autocomplete="off" placeholder="Password Baru" required>
                        <span class="input-group-text btn-show-password cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    @error('new_password')
                        <div class="invalid-feedback d-block text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" autocomplete="off" placeholder="Konfirmasi Password" required>
                        <span class="input-group-text btn-show-password cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    @error('new_password_confirmation')
                        <div class="invalid-feedback d-block text-start">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-outline-danger btn-submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function (e) {
            // (function () {
            //     // Update/reset user image of account page
            //     let accountUserImage = document.getElementById('uploadedAvatar')

            //     const fileInput = document.querySelector('.account-file-input'),
            //     destroyLogo = document.querySelector('[name="destroy_logo"]'),
            //     resetFileInput = document.querySelector('.account-image-reset'),
            //     destroyFileInput = document.querySelector('.account-image-destroy'),
            //     logoPlaceholder = document.querySelector('[name="logo_placeholder"]').value

            //     if (accountUserImage) {
            //         const resetImage = accountUserImage.src
            //         fileInput.onchange = () => {
            //             if (fileInput.files[0]) {
            //                 destroyLogo.value = ''
            //                 accountUserImage.src = window.URL.createObjectURL(fileInput.files[0])
            //                 // console.log(window.URL.createObjectURL(fileInput.files[0]))
            //                 // console.log(fileInput.files[0])
            //             }
            //         }
            //         resetFileInput.onclick = () => {
            //             destroyLogo.value = ''
            //             fileInput.value = ''
            //             accountUserImage.src = resetImage
            //         }
            //         destroyFileInput.onclick = () => {
            //             destroyLogo.value = 'on'
            //             fileInput.value = ''
            //             accountUserImage.src = logoPlaceholder
            //         }
            //     }
            // })()

            $(document).on('click', '.btn-show-password', function (e) {
                const parent = $(this).closest('.input-group')
                const passwordField = $(parent).find('input')
                const showPasswordBtn = $(parent).find('i')
                if (passwordField.attr('type') == 'password') {
                    passwordField.attr('type', 'text')
                    showPasswordBtn.removeClass('bx-hide')
                    showPasswordBtn.addClass('bx-show')
                } else {
                    passwordField.attr('type', 'password')
                    showPasswordBtn.removeClass('bx-show')
                    showPasswordBtn.addClass('bx-hide')
                }
            })
        })
    </script>
@endpush