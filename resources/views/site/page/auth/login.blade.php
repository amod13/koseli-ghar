@extends('site.main.app')
@section('content')
    @include('alert.sitemessage')
    <style>
        .auth-background {
            background: linear-gradient(135deg, #f2f4f7, #dfe3ec);
            min-height: 80vh;
        }
    </style>


    <div class="auth-background py-2">
        <div class="container mb-2 mt-4 py-2">
            <div class="row justify-content-center">
                <div class="col-md-4 col-12">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4">
                            <h2 class="card-title text-center fw-bold mb-3">Login</h2>
                            <hr>
                            <form action="{{ route('user.login.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="loginEmail" class="form-label">Email
                                        address</label>
                                    <input type="email" name="email" class="form-control" id="loginEmail"
                                        placeholder="Enter your email" value="{{ session('email') }}" required>
                                </div>


                                <div class="mb-3 position-relative">
                                    <label for="registerPassword" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" id="registerPassword" required>
                                        <button type="button" class="btn btn-outline-secondary"
                                            id="toggleRegisterPassword">
                                            <i class="far fa-eye" id="registerPasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="login-action mb-20 fix">
                                    <span class="log-rem f-left">
                                        <input id="remember" type="checkbox">
                                        <label for="remember">Remember me!</label>
                                    </span>
                                    <span class="forgot-login f-right">
                                        <a href="{{ route('forgot.password.form') }}">Forgot password?</a>
                                    </span>
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="t-y-btn w-100">Login</button>
                                </div>
                            </form>

                            <div class="text-center my-3">
                                <span class="text-muted">OR</span>
                            </div>

                            <div class="d-grid">
                                <a href="{{ route('user.register') }}" class="t-y-btn t-y-btn-grey w-100">Register</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Toggle Script -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }

        document.getElementById('toggleRegisterPassword').addEventListener('click', function() {
            togglePasswordVisibility('registerPassword', 'registerPasswordIcon');
        });
    </script>
@endsection
