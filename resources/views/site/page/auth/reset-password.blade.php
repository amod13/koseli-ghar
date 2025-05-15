@extends('site.main.app')
@section('content')
    @include('alert.sitemessage')
    <style>
        .auth-background {
            background: linear-gradient(135deg, #f2f4f7, #dfe3ec);
        }
    </style>


    <div class="auth-background py-2">
        <div class="container mb-10 mt-4 py-2">
            <div class="row justify-content-center">
                <div class="col-md-5 col-12">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4">
                            <h2 class="card-title text-center fw-bold mb-3">Create New Password</h2>
                            <hr>
                            <form action="{{ route('reset.password') }}" method="POST">
                                @csrf

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

                                <input type="hidden" name="token" value="{{ $data['token'] }}">
                                <input type="hidden" name="email" value="{{ $data['email'] }}">

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
                                <button type="submit" class="t-y-btn w-100">Change Password</button>
                            </form>

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
