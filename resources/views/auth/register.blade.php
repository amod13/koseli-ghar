@extends('layouts.app')

@section('content')
    @include('alert.message')

    {{-- <section
        class="auth-page-wrapper position-relative bg-light min-vh-100 d-flex align-items-center justify-content-between">
        <div class="w-100">
            <div class="container">
                <div class="card border-0 mb-0">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card-header bg-primary text-white text-center py-4">
                                    <h3 class="fw-light text-white">Sign Up to Your Account</h3>
                                </div>
                                <div class="auth-card mx-lg-3">
                                    <div class="p-2">
                                        <form action="{{ route('register') }}" method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="inputFirstName" class="form-label">{{ __('Name') }}</label>
                                                <input type="text" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="inputFirstName" value="{{ old('name') }}" required
                                                    autocomplete="name" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <input type="hidden" name="role_id" value="3">

                                            <div class="mb-3">
                                                <label for="inputEmailAddress"
                                                    class="form-label">{{ __('Email Address') }}</label>
                                                <input type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="inputEmailAddress" value="{{ old('email') }}" required
                                                    autocomplete="email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="inputChoosePassword"
                                                    class="form-label">{{ __('Password') }}</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" name="password"
                                                        class="form-control border-end-0 @error('password') is-invalid @enderror"
                                                        id="inputChoosePassword" required>
                                                    <a href="javascript:;" class="input-group-text bg-transparent"
                                                        id="toggle-password">
                                                        <i class="fa fa-eye" id="password-icon"></i>
                                                    </a>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="inputChoosePasswordConfirm"
                                                    class="form-label">{{ __('Confirm Password') }}</label>
                                                <div class="input-group" id="show_hide_password_confirm">
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control border-end-0" id="inputChoosePasswordConfirm"
                                                        required>
                                                    <a href="javascript:;" class="input-group-text bg-transparent"
                                                        id="toggle-confirm-password">
                                                        <i class="fa fa-eye" id="confirm-password-icon"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="terms"
                                                    id="terms" required>
                                                <label class="form-check-label" for="terms">I agree to the <a
                                                        href="#">Terms and Conditions</a></label>
                                            </div>

                                            <div class="text-center mb-3">
                                                <p class="mb-0">Already have an account? <a href="{{ route('login') }}"
                                                        class="fw-semibold text-secondary text-decoration-underline">Login
                                                        here</a></p>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" type="submit">Register</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="auth-card mx-lg-3">
                                    <div class="text-center">
                                        <img src="{{ asset('admin/assets/images/login.jpg') }}" alt=""
                                            class="img-fluid" style="border-radius: 10px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- Show/Hide Password --}}
    <script>
        // Toggle password visibility
        const passwordInput = document.getElementById('inputChoosePassword');
        const togglePassword = document.getElementById('toggle-password');
        const passwordIcon = document.getElementById('password-icon');

        togglePassword.addEventListener('click', function() {
            // Toggle password field visibility
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash'); // Change icon to 'eye-slash'
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye'); // Change icon back to 'eye'
            }
        });

        // Toggle confirm password visibility
        const confirmPasswordInput = document.getElementById('inputChoosePasswordConfirm');
        const toggleConfirmPassword = document.getElementById('toggle-confirm-password');
        const confirmPasswordIcon = document.getElementById('confirm-password-icon');

        toggleConfirmPassword.addEventListener('click', function() {
            // Toggle confirm password field visibility
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                confirmPasswordIcon.classList.remove('fa-eye');
                confirmPasswordIcon.classList.add('fa-eye-slash'); // Change icon to 'eye-slash'
            } else {
                confirmPasswordInput.type = 'password';
                confirmPasswordIcon.classList.remove('fa-eye-slash');
                confirmPasswordIcon.classList.add('fa-eye'); // Change icon back to 'eye'
            }
        });
    </script>
@endsection
