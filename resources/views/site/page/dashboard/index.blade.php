@extends('site.main.app')
@section('content')
    @include('alert.sitemessage')

    <main class="bg-light py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="mb-4">
                <h1 class="h3">My Profile Page</h1>
            </div>

            <!-- User Info Row -->
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="border rounded p-4 bg-white h-100">
                        <h4 class="mb-3">User Details</h4>
                        <p><strong>Name:</strong> {{ $data['userDetail']->first_name ?? '' }} </p>
                        <p><strong>Last Name:</strong> {{ $data['userDetail']->last_name ?? '' }}</p>
                        <p><strong>Telephone:</strong> {{ $data['userDetail']->phone ?? '' }}</p>
                        <a href="{{ route('user.detail.form', $data['userId']) }}"
                            class="btn btn-sm btn-outline-primary mt-2">Edit/Change</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="border rounded p-4 bg-white h-100">
                        <h4 class="mb-3">Login Details</h4>
                        <p><strong>Email Address:</strong> user@gmail.com</p>
                        <p><strong>Password:</strong> th******er</p>
                        <a href="{{ route('user.password.form', $data['userId']) }}"
                            class="btn btn-sm btn-outline-primary mt-2">Edit/Change</a>
                    </div>
                </div>
            </div>

            <!-- Address Row -->
            <div class="row g-4 mt-4">
                <div class="col-lg-12">
                    <div class="border rounded p-4 bg-white h-100">
                        <h4 class="mb-3">Billing Address</h4>
                        <p><strong>Address:</strong> {{ $data['userDetail']->address ?? '' }}</p>
                        <a href="{{ route('user.billing.form', $data['userId']) }}"
                            class="btn btn-sm btn-outline-primary mt-2">Edit/Change</a>
                    </div>
                </div>
                {{-- <div class="col-lg-6">
                <div class="border rounded p-4 bg-white h-100">
                    <h4 class="mb-3">Shipping Address</h4>
                    <p><strong>Address:</strong> 97845 Baker st. 567</p>
                    <p><strong>City/Country:</strong> Los Angeles - US</p>
                    <p><strong>Postal Code:</strong> 60515</p>
                    <a href="#0" class="btn btn-sm btn-outline-primary mt-2">Edit/Change</a>
                </div>
            </div> --}}
            </div>

            <!-- Quick Links -->
            <div class="row g-4 mt-4">
                <div class="col-lg-3 col-md-6">
                    <a class="text-decoration-none" href="{{ route('user.orders', $data['userId']) }}">
                        <div class="border rounded p-4 text-center bg-white h-100">
                            <i class="ti-bag display-5 text-primary mb-3"></i>
                            <h5 class="mb-0">My Orders</h5>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a class="text-decoration-none" href="{{ route('user.cart.list', $data['userId']) }}">
                        <div class="border rounded p-4 text-center bg-white h-100">
                            <i class="ti-heart display-5 text-danger mb-3"></i>
                            <h5 class="mb-0">My Cart</h5>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a class="text-decoration-none" href="{{ route('site.wishlist') }}">
                        <div class="border rounded p-4 text-center bg-white h-100">
                            <i class="ti-heart display-5 text-danger mb-3"></i>
                            <h5 class="mb-0">My Wishlist</h5>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a class="text-decoration-none" href="{{ route('user.track.order') }}">
                        <div class="border rounded p-4 text-center bg-white h-100">
                            <i class="ti-comment display-5 text-info mb-3"></i>
                            <h5 class="mb-0">Tracking Order</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
