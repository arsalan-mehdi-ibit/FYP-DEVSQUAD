@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center h-full" style="background-color:white; overflow: hidden;">
        <div class="shadow-lg rounded-3 d-flex flex-column flex-md-row" id="loginContainer"
            style="width: 800px; height: 450px; background-color: white; overflow: hidden;">

            <!-- Left Section (Welcome) - Hidden on Mobile -->
            <div class="d-none d-md-flex flex-column justify-content-center align-items-center text-white text-center"
                style="flex: 1; background: linear-gradient(135deg, #0a192f, #112240); padding: 40px;">
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
                        <input type="email" class="form-control text-black border-0 shadow-sm" name="email"
                            placeholder="Email..." required value="{{ old('email') }}"
                            style="background-color:  #eef0f7; color: #ccd6f6; border-radius: 20px; padding: 10px;">
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
                


                    <div class="text-end mb-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none"
                            style="color: #8892b0;">Forgot your password?</a>

                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn text-white"
                            style="background: linear-gradient(135deg, #0a192f, #112240); border-radius: 20px; padding: 10px;">LOG
                            IN</button>
                    </div>
                </form>

                <p class="mb-0" style="color: #8892b0;">Don't have an account? <a href="{{ route('register') }}"
                        class="text-decoration-none"
                        style="color: linear-gradient(135deg, #0a192f, #112240); font-weight: bold;">Sign Up</a></p>
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

                // Hide pop-up and redirect after 3 seconds
                setTimeout(function() {
                    popup.fadeOut(500, function() {
                        $(this).remove();
                        window.location.href =
                        "{{ route('login') }}"; // Redirect to login page after success message disappears
                    });
                }, 3000);
            });
        </script>
    @endif


@endsection
