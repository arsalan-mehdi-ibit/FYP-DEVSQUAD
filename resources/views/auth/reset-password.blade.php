@extends('layouts.app')

<script>
    $(document).ready(function() {
        let isLoggedIn = {!! auth()->check() ? 'true' : 'false' !!};  // This will be either true or false
        let dashboardUrl = "{{ route('dashboard.index') }}";  

        // Optional: Redirect based on the login status
        if (isLoggedIn) {
            window.location.href = dashboardUrl;
        } else {
            console.log('User is not logged in');
        }
    });
</script>


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
            <form id="reset-password-form" method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">


                <!-- Email Address -->
                <input type="email" id="email" class="mb-3 form-control border-0 shadow-sm" name="email"
                    placeholder="Email..." required value="{{ old('email', $email ?? '') }}" readonly
                    style="background-color: #eef0f7; color: #233554; border-radius: 20px; padding: 10px;">
                <div class="text-danger" id="email-error"></div>

                <!-- New Password -->
                <div class="mb-3 text-start position-relative">
                    <div class="relative">
                        <input id = 'password' type="password" class="form-control border-0 shadow-sm pr-10 password-field"
                            name="password" placeholder="New Password..." required
                            style="background-color: #eef0f7; color: #233554; border-radius: 20px; padding: 10px; width: 100%;">

                        <!-- Eye Icon -->
                        <span class="toggle-password absolute inset-y-0 right-4 flex items-center cursor-pointer">
                            <i class="bi bi-eye-slash text-gray-500"></i>
                        </span>
                    </div>
                    <div class="text-danger" id="password-error"></div>
                    <div class="password-strength mt-2" id="password-strength" style="font-size: 12px; color: #1a2a40;">
                    </div>
                </div>


                <!-- Confirm Password -->
                <div class="mb-3 text-start position-relative">
                    <div class="relative">
                        <input id = 'password_confirmation' type="password"
                            class="form-control border-0 shadow-sm pr-10 password-field" name="password_confirmation"
                            placeholder="Re-enter Password..." required
                            style="background-color: #eef0f7; color: #233554; border-radius: 20px; padding: 10px; width: 100%;">

                        <!-- Eye Icon -->
                        <span class="toggle-password absolute inset-y-0 right-4 flex items-center cursor-pointer">
                            <i class="bi bi-eye-slash text-gray-500"></i>
                        </span>
                    </div>
                    <div class="text-danger" id="password_confirmation-error"></div>
                </div>



                <!-- Submit Button -->
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn text-white"
                        style="background-color: #1a2a40; border-radius: 20px; padding: 10px;">
                        Reset Password
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

                // Hide pop-up and redirect after 3 seconds
                setTimeout(function() {
                    popup.fadeOut(500, function() {
                        $(this).remove();
                        window.location.href = "{{ route('login') }}";
                    });
                }, 3000);
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            // Form validation on submit
            $('#reset-password-form').submit(function(e) {
                e.preventDefault();

                // Clear previous error messages
                $('.text-danger').empty();

                // Get values from form fields
                let email = $('#email').val();
                let password = $('#password').val();
                let passwordConfirmation = $('#password_confirmation').val();

                let isValid = true;

                // Validate Email
                if (!email || !email.match(/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/)) {
                    $('#email-error').text('Please enter a valid email address.');
                    isValid = false;
                }

                // Validate Password
                if (!password || password.length < 8) {
                    $('#password-error').text('Password must be at least 8 characters long.');
                    isValid = false;
                }

                // Validate Password Confirmation
                if (password !== passwordConfirmation) {
                    $('#password_confirmation-error').text('Password confirmation does not match.');
                    isValid = false;
                }

                // Submit the form if all fields are valid
                if (isValid) {
                    this.submit();
                }
            });
        });
    </script>
@endsection
