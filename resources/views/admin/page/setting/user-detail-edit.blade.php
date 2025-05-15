@extends('admin.main.app')
@section('content')
@include('alert.message')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">My Account</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Accounts</a></li>
                        <li class="breadcrumb-item active">My Account</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->


        <form action="{{ route('user.detail.update', $data['userId']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="row">
                <div class="col-lg-3">
                    <h5 class="fs-16">Personal Information</h5>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" value="{{ old('first_name', $data['userDetail']->first_name ?? '') }}">
                                </div>
                                <div class="col-lg-4">
                                    <label for="Middle" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="Middle" name="middle_name" value="{{ old('middle_name', $data['userDetail']->middle_name ?? '') }}">
                                </div>
                                <div class="col-lg-4">
                                    <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="lastName" name="last_name" value="{{ old('last_name', $data['userDetail']->last_name ?? '') }}">
                                </div>
                                <div class="col-lg-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $data['userDetail']->email ?? '') }}">
                                </div>
                                <div class="col-lg-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $data['userDetail']->phone ?? '') }}">
                                </div>
                                <div class="col-lg-4">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation', $data['userDetail']->designation ?? '') }}">
                                </div>
                                <div class="col-lg-4">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="text" class="form-control" id="website" name="website" value="{{ old('website', $data['userDetail']->website ?? '') }}">
                                </div>
                                <div class="col-lg-4">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $data['userDetail']->address ?? '') }}">
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-center mb-3">
                                        <label for="profile-image-input">Add Profile Image</label>
                                        <br>
                                        <div class="position-relative d-inline-block">
                                            <div class="position-absolute top-100 start-100 translate-middle">
                                                <label for="profile-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select company logo">
                                                    <span class="avatar-xs d-inline-block">
                                                        <span class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                            <i class="ri-image-fill"></i>
                                                        </span>
                                                    </span>
                                                </label>
                                                <input class="form-control d-none" id="profile-image-input" type="file" name="image" accept="image/png, image/gif, image/jpeg">
                                            </div>
                                            <div class="avatar-lg">
                                                <div class="avatar-title bg-light rounded-3">
                                                    <img src="{{ asset('uploads/images/user/profile/'. $data['userDetail']->image) }}" alt="{{ $data['userDetail']->name }}" id="userDetailLogo-img" class="avatar-md h-auto object-fit-cover" height="250" width="250">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="row mt-4">
                <div class="col-lg-3">
                    <h5 class="fs-16">Social Media</h5>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', $data['userDetail']->facebook ?? '') }}" placeholder="https://">
                                </div>
                                <div class="col-lg-4">
                                    <label for="whatsapp" class="form-label">Whatsapp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $data['userDetail']->whatsapp ?? '') }}" placeholder="https://">
                                </div>
                                <div class="col-lg-4">
                                    <label for="twitter" class="form-label">Twitter</label>
                                    <input type="text" class="form-control" id="twitter" name="twitter" value="{{ old('twitter', $data['userDetail']->twitter ?? '') }}" placeholder="https://">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="row mt-4">
                <div class="col-lg-3">
                    <h5 class="fs-16">Change Password</h5>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <label for="old_password" class="form-label">Old Password*</label>
                                    <input type="password" class="form-control" id="old_password" name="old_password">
                                </div>
                                <div class="col-lg-4">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                </div>
                                <div class="col-lg-4">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Notifications -->
            <div class="row mt-4">
                <div class="col-lg-3">
                    <h5 class="fs-16">Application Notifications</h5>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-check">
                                <input type="hidden" name="exclusive_offers" value="0">
                                <input class="form-check-input" type="checkbox" id="exclusive_offers" name="exclusive_offers" value="1"
                                    {{ old('exclusive_offers', $data['userDetail']->exclusive_offers ?? 0) ? 'checked' : '' }}>
                                <label class="form-check-label" for="exclusive_offers">Exclusive product offers</label>
                            </div>

                            <div class="form-check">
                                <input type="hidden" name="daily_messages" value="0">
                                <input class="form-check-input" type="checkbox" id="daily_messages" name="daily_messages" value="1"
                                    {{ old('daily_messages', $data['userDetail']->daily_messages ?? 0) ? 'checked' : '' }}>
                                <label class="form-check-label" for="daily_messages">Daily Messages</label>
                            </div>

                            <div class="form-check">
                                <input type="hidden" name="weekly_summary" value="0">
                                <input class="form-check-input" type="checkbox" id="weekly_summary" name="weekly_summary" value="1"
                                    {{ old('weekly_summary', $data['userDetail']->weekly_summary ?? 0) ? 'checked' : '' }}>
                                <label class="form-check-label" for="weekly_summary">Weekly Activity Summary</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </form>



        @endsection
