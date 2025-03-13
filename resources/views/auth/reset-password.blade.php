@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center h-full" style="background-color: white;">
    <div class="shadow-lg rounded-3 p-4 text-center" style="width: 400px; background-color: white;">
        
        <!-- Icon -->
        <div class="text-center mb-3">
            <i class="bi bi-envelope" style="font-size: 50px; color: #233554;"></i>
        </div>

        <!-- Title -->
        <h3 style="color: #233554; font-weight: bold;">Reset Password</h3>
        <p style="color: #1a2a40; font-size: 14px; opacity: 0.8;">Please set your new password</p>


        <!-- Reset Password Form -->
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">


            <!-- Email Address -->
            <div class="mb-3 text-start">
                <input type="email" class="form-control border-0 shadow-sm" name="email" placeholder="Email..." required
                    value="{{ old('email', $request->email) }}" style="background-color: #eef0f7; color: #233554; border-radius: 20px; padding: 10px;">
            </div>

            <!-- New Password -->
            <div class="mb-3 text-start position-relative">
                <input type="password" id="password" class="form-control border-0 shadow-sm" name="password" placeholder="New Password..." required
                    style="background-color: #eef0f7; color: #233554; border-radius: 20px; padding: 10px;">
                <div class="password-strength mt-2" id="password-strength" style="font-size: 12px; color: #1a2a40;"></div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 text-start">
                <input type="password" class="form-control border-0 shadow-sm" name="password_confirmation" placeholder="Re-enter Password..." required
                    style="background-color: #eef0f7; color: #233554; border-radius: 20px; padding: 10px;">
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn text-white" style="background-color: #1a2a40; border-radius: 20px; padding: 10px;">
                    Reset Password
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #1a2a40; font-weight: bold;">← Back to Login</a>
        </div>
    </div>
</div>
@endsection

