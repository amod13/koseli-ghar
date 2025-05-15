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
        <div class="container mb-10 mt-4 py-2">
            <div class="row justify-content-center">
                <div class="col-md-5 col-12">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4">
                            <h2 class="card-title text-center fw-bold mb-3">Register</h2>
                            <hr>
                            <form action="{{ route('user.register.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="registerName" class="form-label">Full
                                        Name</label>
                                    <input type="text" class="form-control" id="registerName" name="name" required value="{{ old('name') }}">
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <label for="registerName" class="form-label">Contact Number</label>
                                    <input type="number" class="form-control" id="registerName" name="phone_number" required value="{{ old('phone_number') }}">
                                    <span class="text-danger">
                                        @error('phone_number')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <label for="registerEmail" class="form-label">Email
                                        address</label>
                                    <input type="email" name="email" class="form-control" id="registerEmail" required value="{{ old('email') }}">
                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <!-- Password Field -->
                                <div class="mb-3 position-relative">
                                    <label for="registerPassword" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="registerPassword" name="password" required>
                                        <button type="button" class="btn btn-outline-secondary"
                                            id="toggleRegisterPassword">
                                            <i class="far fa-eye" id="registerPasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="text-danger">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </span>

                                <!-- Confirm Password Field -->
                                <div class="mb-3 position-relative">
                                    <label for="registerConfirm" class="form-label">Confirm
                                        Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="registerConfirm" name="password_confirmation" required>
                                        <button type="button" class="btn btn-outline-secondary" id="toggleRegisterConfirm">
                                            <i class="far fa-eye" id="registerConfirmIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="login-action mb-20 fix">
                                    <span class="log-rem f-left">
                                        <input id="remember" type="checkbox" required>
                                        <label for="remember">I accept Terms and Policy</label>
                                    </span>
                                </div>
                                <button type="submit" class="t-y-btn w-100">Register</button>
                            </form>

                            <div class="text-center my-3">
                                <span class="text-muted">OR</span>
                            </div>

                            <div class="d-grid">
                                <a href="{{ route('user.login') }}" class="t-y-btn t-y-btn-grey w-100">Login</a>
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

        document.getElementById('toggleRegisterConfirm').addEventListener('click', function() {
            togglePasswordVisibility('registerConfirm', 'registerConfirmIcon');
        });
    </script>
@endsection
