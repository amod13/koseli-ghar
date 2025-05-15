<!-- preloader area start -->
{{-- <div id="loading">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div id="object"></div>
                </div>
            </div>
        </div> --}}
<!-- preloader area end -->

<!-- back to top start -->
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
<!-- back to top end -->

<!-- header area start -->
<header>
    <div class="header__area">
        {{-- Top Header --}}
        <div class="header__top d-none d-sm-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-5 d-none d-md-block">
                        <div class="header__welcome">
                            <span>Welcome to {{ $data['setting']->site_name }}</span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-7">
                        <div class="header__action d-flex justify-content-center justify-content-md-end">
                            <ul>

                                {{-- If the user is not logged in --}}
                                @guest
                                    <li class="nav-item">
                                        <a href="{{ route('user.login') }}" class="nav-link">
                                            <i class="fa fa-sign-in-alt me-1"></i> Sign In
                                        </a>
                                    </li>
                                @endguest

                                {{-- If the user is logged in --}}
                                @if (Auth::check() && Auth::user()->role_id == 1)
                                    {{-- Content for role_id 1 --}}
                                    <li class="nav-item dropdown">
                                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                            <i class="fas fa-user-circle fs-5"></i> <span
                                                class="ms-1">{{ Auth::user()->name }} Dashboard</span>
                                        </a>
                                    </li>
                                @else
                                    @auth
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
                                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-user-circle fs-5"></i> {{ Auth::user()->name }} Account
                                            </a>

                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('site.user.profile') }}">
                                                        <i class="fas fa-user text-muted me-2"></i> My Profile
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="{{ route('site.user.profile') }}">
                                                        <i class="fas fa-map-marker-alt text-muted me-2"></i> My Address
                                                        Book
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.orders', Auth::user()->id) }}">
                                                        <i class="fas fa-shopping-bag text-muted me-2"></i> My Orders
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="{{ route('site.wishlist') }}">
                                                        <i class="fas fa-heart text-muted me-2"></i> My Wishlist
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="{{ route('user.track.order') }}">
                                                        <i class="fas fa-shipping-fast text-muted me-2"></i> Track Order
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="document.getElementById('logout-form').submit();">
                                                        <i class="fas fa-sign-out-alt text-muted me-2"></i> Logout
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    @endauth
                                @endif



                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Header --}}
        <div class="header__info">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-xl-4 col-lg-3">
                        <div
                            class="header__info-left d-flex justify-content-center justify-content-sm-between align-items-center">
                            <div class="logo">
                                <a href="{{ url('/') }}"><img
                                        src="{{ asset('uploads/images/site/' . $data['setting']->logo) }}"
                                        alt="{{ $data['setting']->site_name }}"></a>
                            </div>
                            <div class="header__hotline align-items-center d-none d-sm-flex  d-lg-none d-xl-flex">
                                <div class="header__hotline-icon">
                                    <i class="fal fa-headset"></i>
                                </div>
                                <div class="header__hotline-info">
                                    <span>Contact Number:</span>
                                    <h6> <a href="tel:{{ $data['setting']->phone }}">{{ $data['setting']->phone }}</a>
                                    </h6>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-lg-9">
                        <div class="header__info-right">

                            <div class="header__search f-left d-none d-sm-block">
                                <form role="search" method="get" class="search-form"
                                    action="{{ route('site.search') }}">
                                    @csrf
                                    <div class="input-group main-search">
                                        <input type="search" class="form-control" placeholder="Search For Products..."
                                            value="{{ request('search_keyword') }}" name="search_keyword" required />

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-search">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="cart__mini-wrapper d-none d-md-flex f-right p-relative">
                                <a href="javascript:void(0);" class="cart__toggle">
                                    <!-- Display cart item count -->
                                    <span class="cart__total-item">{{ $data['cartItems']->count() }}</span>
                                </a>
                                @if ($data['cartItems']->count() > 0)
                                    <span class="cart__content">
                                        <span class="cart__my">My Cart:</span>
                                        <!-- Display total price dynamically -->
                                        <span class="cart__total-price">Rs.
                                            {{ number_format($data['totalPrice'], 2) }}</span>
                                    </span>
                                    <div class="cart__mini">
                                        <div class="cart__close">
                                            <button type="button" class="cart__close-btn"><i
                                                    class="fal fa-times"></i></button>
                                        </div>
                                        <ul>
                                            <li>
                                                <div class="cart__title">
                                                    <h4>My Cart</h4>
                                                    <span>({{ $data['cartItems']->count() }}
                                                        Item{{ $data['cartItems']->count() > 1 ? 's' : '' }} in
                                                        Cart)</span>
                                                </div>
                                            </li>

                                            @foreach ($data['cartItems'] as $item)
                                                <li>
                                                    <div
                                                        class="cart__item d-flex justify-content-between align-items-center">
                                                        <div class="cart__inner d-flex">
                                                            <div class="cart__thumb">
                                                                <a href="product-details.html">
                                                                    <img src="{{ asset('uploads/images/product/thumbnailImage/' . $item->image) }}"
                                                                        alt="{{ $item->product_name }}">
                                                                </a>
                                                            </div>
                                                            <div class="cart__details">
                                                                <h6><a
                                                                        href="{{ route('single.product.view', $item->slug) }}">{{ $item->product_name }}
                                                                        * ({{ $item->quantity }})</a>
                                                                </h6>
                                                                @php
                                                                    $productPrice =
                                                                        $item->product_price * $item->quantity;
                                                                @endphp
                                                                <div class="cart__price">
                                                                    <span>Rs. {{ $productPrice }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="cart__del">
                                                            <form action="{{ route('site.cart.delete', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"><i
                                                                        class="fal fa-trash-alt"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach


                                            <li>
                                                <div
                                                    class="cart__sub d-flex justify-content-between align-items-center">
                                                    <h6>Cart Subtotal</h6>
                                                    <!-- Display the subtotal dynamically -->
                                                    <span class="cart__sub-total">Rs.
                                                        {{ number_format($data['totalPrice'], 2) }}</span>
                                                </div>
                                            </li>
                                            <li>

                                                <a href="{{ route('site.checkout') }}"
                                                    class="t-y-btn w-100 mb-10">Proceed
                                                    to checkout</a>

                                                <a href="{{ route('site.cart.list') }}"
                                                    class="t-y-btn t-y-btn-border w-100 mb-10">View Cart</a>

                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</header>
<!-- header area end -->



<!-- Mobile View Site Search Filter Start-->
<form role="search" method="get" class="search-form mobile-search sticky-search"
    action="{{ route('site.search') }}">
    @csrf
    <div class="input-group main-search">
        <input type="search" class="form-control" placeholder="Search For Products..."
            value="{{ request('search_keyword') }}" name="search_keyword" required />
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary btn-search">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>
{{-- <!-- Mobile View Site Search Filter End --}}


<!-- offcanvas area start -->
<div class="offcanvas__area">
    <div class="offcanvas__wrapper">
        <div class="offcanvas__close">
            <button class="offcanvas__close-btn" id="offcanvas__close-btn">
                <i class="fal fa-times"></i>
            </button>
        </div>
        <div class="offcanvas__content">
            <div class="offcanvas__logo mb-40">
                <a href="index.html">
                    <img src="assets/img/logo/logo-black.png" alt="logo">
                </a>
            </div>
            <div class="offcanvas__search mb-25">
                <form action="#">
                    <input type="text" placeholder="What are you searching for?">
                    <button type="submit"><i class="far fa-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu fix"></div>
            <div class="offcanvas__action">

            </div>
        </div>
    </div>
</div>
<!-- offcanvas area end -->
<div class="body-overlay"></div>
<!-- offcanvas area end -->


<main>
