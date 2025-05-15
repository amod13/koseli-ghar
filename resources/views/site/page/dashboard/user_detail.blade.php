@extends('site.main.app')
@section('content')
    @include('alert.sitemessage')

    <main class="bg-light py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h1 class="h3 m-0">Edit Detail</h1>
                <a href="{{ route('site.user.profile', $data['userId']) }}" class="t-y-btn">
                    <i class="bi bi-arrow-left me-1"></i> Back to Profile
                </a>
            </div>


            <!-- User Info Row -->
            <div class="row g-4 mt-4">
                <form action="{{ route('user.detail.form.update', $data['userId']) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-lg-12 row border rounded p-4 bg-white h-100">

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ $data['userDetail']->first_name ?? '' }}">
                            </div>
                            <span class="text-danger">
                                @error('first_name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" value="{{ $data['userDetail']->middle_name ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ $data['userDetail']->last_name ?? '' }}">
                                <span class="text-danger">
                                    @error('last_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" name="phone" class="form-control" placeholder="98.." value="{{ $data['userDetail']->phone ?? Auth::user()->phone_number ?? '' }}">
                            </div>
                            <span class="text-danger">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="test@.." value="{{ $data['userDetail']->email ?? Auth::user()->email ?? '' }}">
                            </div>
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Image</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">

                                @if (!empty($data['userDetail']->image))
                                    <img src="{{ asset('uploads/images/user/profile/' . $data['userDetail']->image) }}"
                                         alt="{{ $data['userDetail']->first_name ?? 'User Image' }}"
                                         height="100" class="mt-2 d-block rounded border">
                                @endif

                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <input type="hidden" name="user_id" value="{{ $data['userId'] }}">

                        <div class="col-12 text-end">
                            <button type="submit" class="t-y-btn">Update</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
