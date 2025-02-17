@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Login to DEV SQUAD</h4>
                </div>

                <div class="card-body">
                    <!-- Show validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Email Address -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required value="{{ old('email') }}">
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <!-- Remember Me -->
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </form>


                    <div class="text-center">
                        <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary">Register Here</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
