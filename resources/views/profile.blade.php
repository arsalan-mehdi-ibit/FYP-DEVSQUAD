@extends('layouts.app') 

@section('content')
    <style>
        .success-popup {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #38a169;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: opacity 0.3s ease-in-out;
        }
    </style>

    <div class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">
        <div class="w-full">
            <h3 class="text-xxl font-semibold">Profile</h3>

            <div class="mt-4 w-32 sm:w-40">
                <a href="{{ url()->previous() }}" class="back-button">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <div class="card mb-4 mt-4 profile-card ml-0 sm:ml-5 p-3">
                <form id="updateProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body p-3">
                        <div class="d-flex justify-content-center mb-4 mt-2">
                            <div class="profile-picture text-center">
                                <div class="rounded-circle overflow-hidden border border-secondary mx-auto"
                                    style="width: 120px; height: 120px;">
                                    <img id="profile-pic-preview"
                                        src="{{ $profilePicture && $profilePicture->file_path
                                            ? asset($profilePicture->file_path)
                                            : asset('assets/profile.jpeg') }}"
                                        alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div class=" mt-1">
                                    <label for="profile-pic-upload" class="upload-text cursor-pointer">
                                        Upload Photo
                                    </label>
                                    <input type="file" name="attachments" id="profile-pic-upload" class="d-none" accept="image/*" />
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="file_for" value="profile">

                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <label for="first_name">First Name</label>
                                <input required value="{{ $user->firstname }}" type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="middle_name">Middle Name</label>
                                <input value="{{ $user->middlename }}" type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter your middle name">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="last_name">Last Name</label>
                                <input required value="{{ $user->lastname }}" type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input value="{{ $user->email }}" disabled type="email" class="form-control" id="email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone Number</label>
                                <input required value="{{ $user->phone }}" type="text" class="form-control" id="phone" name="phone" maxlength="14" placeholder="Enter your phone number">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3 position-relative">
                                <label for="password">Password (Optional)</label>
                                <div class="position-relative">
                                    <input type="password" class="password-field pr-5" id="password" name="password" placeholder="Enter new password" style="color: black; border-radius: 8px; padding: 7px; width: 100%; border: 1px solid gray;">
                                    <span class="toggle-password" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%);">
                                        <i class="bi bi-eye-slash text-gray-500" data-target="password_field"></i>
                                    </span>
                                    <small id="password-error" class="text-danger"></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 position-relative">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="position-relative">
                                    <input type="password" class="password-field pr-5" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" style="color: black; border-radius: 8px; padding: 7px; width: 100%; border: 1px solid gray;">
                                    <span class="toggle-password absolute inset-y-0 right-4 flex items-center cursor-pointer">
                                        <i class="bi bi-eye-slash text-gray-500" data-target="password_field"></i>
                                    </span>
                                    <small id="password_confirmation-error" class="text-danger"></small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="submit"
                                class="px-4 py-2 text-sm sm:text-base font-medium text-white bg-gradient-to-r from-blue-900 to-blue-700 hover:from-blue-700 hover:to-blue-900 rounded-lg shadow-sm transform hover:scale-105 transition-all duration-300"
                                style="width: 300px;">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div id="profileSuccessPopup" class="success-popup">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const popup = document.getElementById('profileSuccessPopup');
                if (popup) {
                    popup.style.opacity = '0';
                    setTimeout(() => popup.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <script>
        $(document).ready(function () {
            $('#profile-pic-upload').on('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#profile-pic-preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#updateProfileForm').submit(function (e) {
                e.preventDefault();
                $('.text-danger').empty();

                let password = $('#password').val();
                let passwordConfirmation = $('#password_confirmation').val();

                let isValid = true;
                if (password && password.length < 8) {
                    $('#password-error').text('Password must be at least 8 characters long.');
                    isValid = false;
                }

                if (password && password !== passwordConfirmation) {
                    $('#password_confirmation-error').text('Password confirmation does not match.');
                    isValid = false;
                }

                if (isValid) {
                    this.submit();
                }
            });
        });
    </script>
@endsection
