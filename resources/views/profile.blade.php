@extends('layouts.app')

@section('content')

<div class="main-layout row mt-4 mx-4">
    <div class="col-12">
        <h3>Profile</h3>

        <div class="col-3 mt-4">
            <a href="{{ url()->previous() }}" class="back-button">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="card mb-4 mt-4 profile-card">
            <form id="updateProfileForm" method="POST" action="{{ route('profile.update') }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    {{-- Profile Picture --}}
                    <div class="d-flex justify-content-center mb-4">
                        <div class="profile-picture text-center">
                            <img id="profile-pic-preview"
                                 src="{{ $user->profile_picture 
                                        ? asset('storage/profile_pictures/' . $user->profile_picture) 
                                        : asset('assets/profile.jpeg') }}"
                                 alt="Profile Picture" class="rounded-circle" width="100" height="100">
                            <div class="upload-container mt-2">
                                <label for="profile-pic-upload" class="upload-text">
                                    Upload Photo
                                </label>
                                <input type="file" name="profile_picture" id="profile-pic-upload" class="d-none" accept="image/*" />
                            </div>
                        </div>
                    </div>

                    {{-- Profile Fields --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name">First Name</label>
                            <input required value="{{  $user->firstname }}" type="text"
                                   class="form-control" id="first_name" name="first_name"
                                   placeholder="Enter your first name">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="last_name">Last Name</label>
                            <input required value="{{  $user->lastname }}" type="text"
                                   class="form-control" id="last_name" name="last_name"
                                   placeholder="Enter your last name">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input value="{{ $user->email }}" disabled type="email" class="form-control"
                                   id="email">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone">Phone Number</label>
                            <input required value="{{  $user->phone }}" type="text"
                                   class="form-control" id="phone" name="phone"
                                   maxlength="14" placeholder="Enter your phone number">
                        </div>
                    </div>

                    {{-- Optional Password Fields --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password">Password (Optional)</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Enter new password">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   name="password_confirmation" placeholder="Confirm new password">
                        </div>
                    </div>

                    {{-- Save Button --}}
                    <div class="d-flex justify-content-center mt-5">
                        <button type="submit" class="btn btn-primary" style="width: 300px;">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JS for Profile Picture Preview --}}
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
