@extends('layouts.app')

@section('content')
<div id="invoice" class="max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">
    <div class="bg-gray-100  p-2 md:max-w-2xl lg:max-w-3xl mx-auto">
        
        
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Profile Photo Upload -->
            <div class="flex justify-center mb-1">
                <label for="profile_photo" class="relative cursor-pointer">
                    <img id="preview" class="w-24 h-24 rounded-full border-4 border-gray-300 object-cover" 
                         src="{{ asset('images/default-avatar.png') }}" 
                         alt="">
                    <span class="absolute bottom-2 right-2 bg-black text-white p-1 rounded-full">
                        <i class="bi bi-camera-fill"></i>
                    </span>
                </label>
                <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*" onchange="previewImage(event)">
            </div>
            <p class="text-center text-sm text-gray-500 font-medium">Upload Photo</p>

            <!-- Input Fields -->
            <div class="row g-4 mt-2">
                <div class="col-md-6 m-0">
                    <label class="form-label text-gray-600">First Name</label>
                    <input type="text" class="form-control" name="first_name" placeholder="Enter your first name">
                </div>
                <div class="col-md-6 m-0">
                    <label class="form-label text-gray-600">Last Name</label>
                    <input type="text" class="form-control" name="last_name" placeholder="Enter your last name">
                </div>
                <div class="col-md-6 ">
                    <label class="form-label text-gray-600">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-gray-600">Phone Number</label>
                    <input type="text" class="form-control" name="phone" placeholder="Enter your phone number">
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-dark w-40 px-3 py-2 rounded-xl">Save</button>
            </div>
        </form>
    </div>

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
                                <input type="password" class="form-control form-control-lg" id="password" name="password"
                                    data-parsley-equalto="#confirm_password"
                                    placeholder=" ">
                               
                            </div>

                            <div class="col-md-6 mb-3 position-relative">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control form-control-lg" id="confirm_password" name="password_confirmation"
                                    data-parsley-equalto="#password"
                                    placeholder=" ">
                               
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