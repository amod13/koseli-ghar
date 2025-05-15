@extends('site.main.app')
@section('content')
@include('alert.sitemessage')

<main class="bg-light py-5">
    <div class="container">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h1 class="h3 m-0">Change Password</h1>
            <a href="{{ route('site.user.profile', $data['userId']) }}" class="t-y-btn">
                <i class="bi bi-arrow-left me-1"></i> Back to Profile
            </a>
        </div>

        <!-- Form Start -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="{{ route('user.detail.form.update', $data['userId']) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Old Password -->
                                <div class="col-md-4 position-relative">
                                    <label for="old_password" class="form-label">Old Password*</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="old_password" name="old_password">
                                        <span class="input-group-text toggle-password" data-target="old_password" style="cursor:pointer;">👁️</span>
                                    </div>
                                    <span class="text-danger">
                                        @error('old_password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <!-- New Password -->
                                <div class="col-md-4 position-relative">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password" name="new_password">
                                        <span class="input-group-text toggle-password" data-target="new_password" style="cursor:pointer;">👁️</span>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-4 position-relative">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                        <span class="input-group-text toggle-password" data-target="confirm_password" style="cursor:pointer;">👁️</span>
                                    </div>
                                </div>

                                <input type="hidden" name="user_id" value="{{ $data['userId'] }}">

                                <!-- Submit Button -->
                                <div class="col-12 text-end mt-3">
                                    <button type="submit" class="btn btn-primary px-4">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- Form End -->
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-password').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const input = document.getElementById(this.dataset.target);
                if (input.type === 'password') {
                    input.type = 'text';
                    this.innerHTML = '🙈';
                } else {
                    input.type = 'password';
                    this.innerHTML = '👁️';
                }
            });
        });
    });
</script>
@endpush
