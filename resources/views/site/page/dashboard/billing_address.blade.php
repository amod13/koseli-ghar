@extends('site.main.app')
@section('content')
    @include('alert.sitemessage')

    <main class="bg-light py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h1 class="h3 m-0">Edit Address</h1>
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

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Baneswor-10,Buddhnagar" value="{{ $data['userDetail']->address ?? '' }}">
                            </div>
                            <span class="text-danger">
                                @error('address')
                                    {{ $message }}
                                @enderror
                            </span>
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
