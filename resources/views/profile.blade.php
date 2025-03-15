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


@endsection