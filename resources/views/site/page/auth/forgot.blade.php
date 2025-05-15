@extends('site.main.app')
@section('content')
@include('alert.sitemessage')

<div class="auth-background py-2">
    <div class="container mb-2 mt-4 py-2">
        <div class="row justify-content-center">
            <div class="col-md-4 col-12">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center fw-bold mb-3">Reset Password</h2>
                        <hr>
                        <form action="{{ route('forgot.password.send.email') }}" method="GET">
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" id="loginEmail"
                                    placeholder="Enter your email address" required>
                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="t-y-btn w-100">Send Password Reset Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
