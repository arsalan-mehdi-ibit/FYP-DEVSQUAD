@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center h-full" style="background-color:white; overflow: hidden;">
    <div class="shadow-lg rounded-3 d-flex flex-column flex-md-row" id="loginContainer" style="width: 800px; height: 450px; background-color: white; overflow: hidden;">
        
        <!-- Left Section (Welcome) - Hidden on Mobile -->
        <div class="d-none d-md-flex flex-column justify-content-center align-items-center text-white text-center" style="flex: 1; background: linear-gradient(135deg, #0a192f, #112240); padding: 40px;">
            <h3 style="font-weight: bold;color:white">Welcome Back!</h3>
            <p style="opacity: 0.8;">To stay connected with us, please login with your personal info</p>
        </div>

        <!-- Right Section (Login) - Always Visible -->
        <div class="d-flex flex-column justify-content-center align-items-center" style="flex: 1; padding: 40px;">
            <h3 style="color: #343f68; font-weight: bold;">Welcome</h3>
            <p style="font-size: 14px; opacity: 1; color: #5c6583;">Login into your account to continue</p>
            
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
            
            <form method="POST" action="{{ route('login') }}" style="width: 100%;">
                @csrf
                
                <!-- Email Address -->
                <div class="mb-3 text-start">
                    <input type="email" class="form-control border-0 shadow-sm" name="email" placeholder="Email..." required value="{{ old('email') }}" style="background-color:  #eef0f7; color: #ccd6f6; border-radius: 20px; padding: 10px;">
                </div>

                <!-- Password -->
                <div class="mb-3 text-start">
                    <input type="password" class="form-control border-0 shadow-sm" name="password" placeholder="Password..." required style="background-color:  #eef0f7; color: #ccd6f6; border-radius: 20px; padding: 10px;">
                </div>

                <div class="text-end mb-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #8892b0;">Forgot your password?</a>

                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #0a192f, #112240); border-radius: 20px; padding: 10px;">LOG IN</button>
                </div>
            </form>

            <p class="mb-0" style="color: #8892b0;">Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none" style="color: linear-gradient(135deg, #0a192f, #112240); font-weight: bold;">Sign Up</a></p>
        </div>
    </div>
</div>
@endsection
