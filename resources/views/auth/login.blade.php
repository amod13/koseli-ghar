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
                                    <h3 class="fw-light text-white">Login to Your Account</h3>
                                </div>
                                <div class="auth-card mx-lg-3">
                                    <div class="p-2">
                                        <form action="{{ route('login') }}" method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="inputEmailAddress" class="form-label">User Email</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i class="fa fa-envelope"></i></span>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="inputEmailAddress" name="email" placeholder=""
                                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                </div>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="inputChoosePassword" class="form-label">User Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <span class="input-group-text bg-light"><i class="fa fa-lock"></i></span>
                                                    <input type="password"
                                                        class="form-control border-end-0 @error('password') is-invalid @enderror"
                                                        id="inputChoosePassword" name="password" placeholder="" required
                                                        autocomplete="current-password">
                                                    <a href="javascript:;" class="input-group-text bg-transparent"
                                                        id="toggle-password">
                                                        <i class="fa-regular fa-eye" id="password-icon"></i>
                                                    </a>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="remember">{{ __('Remember Me') }}</label>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                            </div>
                                        </form>
                                        <div class="text-center mt-4">
                                            <p><a href="#" class="text-decoration-none text-primary">Forgot Password?</a></p>
                                            <p>Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary">Sign Up</a></p>
                                        </div>

                                        <div class="continue">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <hr>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <p class="text-muted fw-medium mb-0">OR</p>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <hr>
                                                </div>
                                            </div>

                                            <div class="mt-3 text-center">
                                                <a href="{{ route('google.redirect') }}" class="btn btn-outline-danger w-100 mb-2">
                                                    <i class="fab fa-google me-2"></i> Continue with Google
                                                </a>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="auth-card mx-lg-3">
                                    <div class="text-center">
                                        <img src="{{ asset('admin/assets/images/login.jpg') }}" alt=""
                                            class="img-fluid">
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
        // Get the input element and the icon
        const passwordInput = document.getElementById('inputChoosePassword');
        const togglePassword = document.getElementById('toggle-password');
        const passwordIcon = document.getElementById('password-icon');

        // Toggle the password visibility on click
        togglePassword.addEventListener('click', function() {
            // Check the current input type and toggle it
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
    </script>
@endsection
