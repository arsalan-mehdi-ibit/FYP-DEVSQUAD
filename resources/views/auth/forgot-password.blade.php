@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center h-full" style="background-color: white; overflow: hidden;">
    <div class="shadow-lg rounded-3 p-4 text-center" style="width: 400px; background-color: white;">

        <!-- Alert Icon -->
        <div class="text-center mb-3">
            <i class="bi bi-exclamation-circle-fill" style="font-size: 50px; color: #233554;"></i>
        </div>

        <!-- Title -->
        <h3 style="color: #233554; font-weight: bold;">Forgot Password</h3>
        <p style="color: #1a2a40; font-size: 14px; opacity: 0.8;">
            Enter your email and we'll send you a link to reset your password.
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-3" :status="session('status')" />

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Input -->
            <div class="mb-3 text-start">
                <input type="email" class="form-control text-black border-0 shadow-sm" name="email" placeholder="Email..."
                    required value="{{ old('email') }}"
                    style="background-color:  #eef0f7; color: #233554; border-radius: 20px; padding: 10px;">
            </div>

            <!-- Error Message -->
            @if ($errors->has('email'))
                <p class="text-danger mb-3" style="font-size: 14px;">
                    {{ $errors->first('email') }}
                </p>
            @endif

            <!-- Submit Button -->
            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn text-white"
                    style="background-color: #1a2a40; border-radius: 20px; padding: 10px;">
                    Submit
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #1a2a40; font-weight: bold;">←
                Back to Login</a>
        </div>

    </div>
</div>

@if (session('success'))
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let message = "{{ session('success') }}";
        let popup = $('<div></div>').text(message).css({
            position: "fixed",
            top: "20px",
            left: "50%",
            transform: "translateX(-50%)",
            background: "#28a745",
            color: "white",
            padding: "10px 20px",
            borderRadius: "5px",
            boxShadow: "0px 4px 6px rgba(0,0,0,0.1)",
            zIndex: "1000"
        });

        $("body").append(popup);

    });
</script>
@endif
@endsection
