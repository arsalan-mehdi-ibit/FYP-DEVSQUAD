@extends('layouts.app')

@section('content')

<div class="main-layout row mt-4 mx-4">
        <div class="col-12">
            <h3>Profile</h3>

            <div class="col-3 mt-4">
                            <a href="{{url()->previous()  }}" class="back-button">
                                <i class="bi bi-arrow-left"></i>
                                Back
                            </a>
                        </div>
            <div class="card mb-4 mt-4 profile-card">
                <form id = "updateProfileForm" method="POST" action=""
                      enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="d-flex justify-content-center mb-4">
                            <div class="profile-picture text-center">
                                <img id="profile-pic-preview"
                                     src="{{ asset('assets/profile.jpeg') }}"
                                     alt="Profile Picture" class="rounded-circle" width="100" height="100">
                                <div class="upload-container mt-2">
                                    <label for="profile-pic-upload" class="upload-text">
                                        Upload Photo
                                    </label>
                                    <input type="file" name="profile_pic" id="profile-pic-upload" class = 'd-none' accept="image/*"/>
                                </div>
                            </div>
                        </div>

                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name">First Name</label>
                                    <input required value="Arsalan" type="text"
                                           class="form-control dark-gray-input" id="first_name" name="first_name"
                                           placeholder="Enter your first name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name">Last Name</label>
                                    <input required value="Mehdi" type="text" class="form-control"
                                           id="last_name" name="last_name" placeholder="Enter your last name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email">Email</label>
                                    <input value="admin@gmail.com" disabled type="email" class="form-control"
                                           id="email" placeholder="Enter your email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone">Phone Number</label>
                                    <input required value="03237591214" type="text" class="form-control"
                                           id="phone" name="phone"
                                           maxlength="14"
                                           data-parsley-maxlength="15" placeholder="Enter your phone number">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3 position-relative">
                                    <label for="password">Password (Optional)</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg password-field" id="password" name="password"
                                            data-parsley-equalto="#confirm_password" placeholder=" ">
                                            <span class="toggle-password absolute inset-y-0 right-4 flex items-center cursor-pointer">
                                                <i class="bi bi-eye-slash text-gray-500"></i>
                                            </span>
                                    </div>
                                </div>
                            
                                <div class="col-md-6 mb-3 position-relative">
                                    <label for="confirm_password">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg password-field" id="confirm_password" name="password_confirmation"
                                            data-parsley-equalto="#password" placeholder=" ">
                                     <!-- Eye Icon -->
                                    <span class="toggle-password absolute inset-y-0 right-4 flex items-center cursor-pointer">
                                        <i class="bi bi-eye-slash text-gray-500"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            
                           
                            <div class="d-flex justify-content-center mt-5">
                                <button type="button" class=" border-radius-2xl btn btn-primary" id="save-profile"
                                        style="width: 300px;">Save
                                </button>
                            </div>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        console.log("here i comes");
        $('#profile-pic-upload').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profile-pic-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection