@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center h-full" style="background-color: rgba(255, 255, 255, 0.9); overflow: hidden;">
    <div class="shadow-lg rounded-3 d-flex flex-column flex-md-row" id="registerContainer" style="width: 800px; height: 500px; background-color: white; overflow: hidden;">
        
        <!-- Left Section (Welcome) - Hidden on Mobile -->
        <div class="d-none d-md-flex flex-column justify-content-center align-items-center text-white text-center" style="flex: 1; background: linear-gradient(135deg, #233554, #1a2a40); padding: 40px;">
            <h3 style="font-weight: bold;color:white">Join Us!</h3>
            <p style="opacity: 0.8;">Create an account to become a part of our community</p>
        </div>

        <!-- Right Section (Register) - Always Visible -->
        <div class="d-flex flex-column justify-content-center align-items-center" style="flex: 1; padding: 40px;">
            <h3 style="color: #233554; font-weight: bold;">Sign Up</h3>
            <p style="font-size: 14px; opacity: 0.8; color: #1a2a40;">Create your account to continue</p>
            
            <!-- Show validation errors -->
            @if ($errors->any())
                <div class="alert alert-danger text-start">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}" style="width: 100%;">
                @csrf
                
                <!-- Name -->
                <div class="mb-3 text-start">
                    <input type="text" class="form-control text-black border-0 shadow-sm" name="name" placeholder="Name..." required value="{{ old('name') }}" style="background-color:  #eef0f7; color: #ccd6f6; border-radius: 20px; padding: 10px;">
                </div>

                <!-- Email Address -->
                <div class="mb-3 text-start">
                    <input type="email" class="form-control text-black border-0 shadow-sm" name="email" placeholder="Email..." required value="{{ old('email') }}" style="background-color:  #eef0f7; color: #ccd6f6; border-radius: 20px; padding: 10px;">
                </div>

                <!-- Password -->
                <div class="mb-3 text-start relative">
                    <div class="relative">
                        <input type="password" class="form-control border-0 text-black shadow-sm pr-10 password-field" 
                            name="password" placeholder="Password..." required 
                            style="background-color: #eef0f7; color: #ccd6f6; border-radius: 20px; padding: 10px; width: 100%;">
                        
                        <!-- Eye Icon -->
                        <span class="toggle-password absolute inset-y-0 right-4 flex items-center cursor-pointer">
                            <i class="bi bi-eye-slash text-gray-500"></i>
                        </span>
                    </div>
                </div>
                

                <!-- Confirm Password -->
                <div class="mb-3 text-start relative">
                    <div class="relative">
                        <input type="password" class="form-control text-black border-0 shadow-sm pr-10 password-field" 
                            name="password_confirmation" placeholder="Confirm Password..." required 
                            style="background-color: #eef0f7; color: #ccd6f6; border-radius: 20px; padding: 10px; width: 100%;">
                        
                        <!-- Eye Icon -->
                        <span class="toggle-password absolute inset-y-0 right-4 flex items-center cursor-pointer">
                            <i class="bi bi-eye-slash text-gray-500"></i>
                        </span>
                    </div>
                </div>
                

                <!-- Submit Button -->
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn text-white" style="background-color: #1a2a40; border-radius: 20px; padding: 10px;">SIGN UP</button>
                </div>
            </form>

            <p class="mb-0" style="color: #233554;">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none" style="color: #1a2a40; font-weight: bold;">Log In</a></p>
        </div>
    </div>
</div>
@endsection
