@extends('site.main.app')
@section('content')
    @include('alert.sitemessage')

    <!-- slider area satrt -->
    <section class="slider__area pt-30 grey-bg">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 custom-col-2 d-none d-xl-block">
                    <div class="cat__menu-wrapper">
                        <div class="cat-toggle">
                            <button type="button" class="cat-toggle-btn"><i class="fas fa-bars"></i> Shop by
                                Categories</button>
                            <div class="cat__menu">
                                <nav id="mobile-menu">
                                    <ul>
                                        @foreach ($data['brandBaseCategory'] as $category)
                                            <li>
                                                <a href="{{ route('category.slug', $category['category_slug']) }}">
                                                    {{ $category['category_name'] }}
                                                    @if ($data['setting']->is_display_brand_slider == 1)
                                                        <i class="fa-solid fa-angle-down"></i>
                                                    @endif
                                                </a>

                                                @if ($data['setting']->is_display_brand_slider == 1)
                                                    @if (count($category['brands']) > 0)
                                                    <ul class="submenu">
                                                        <div id="brand-search-form">
                                                            @foreach ($category['brands'] as $brand)
                                                                <li>
                                                                    @php
                                                                        $brandInputId =
                                                                            'brand-' .
                                                                            $category['category_slug'] .
                                                                            '-' .
                                                                            $loop->index;
                                                                    @endphp
                                                                    <input type="radio" id="{{ $brandInputId }}"
                                                                        name="brand_id" value="{{ $brand['brand_slug'] }}"
                                                                        style="display:none;" class="brand-radio">

                                                                    <a href="javascript:void(0);" class="brand-link"
                                                                        data-target="{{ $brandInputId }}">
                                                                        {{ $brand['brand_name'] }}
                                                                    </a>
                                                                </li>
                                                            @endforeach

                                                        </div>
                                                    </ul>
                                                @endif
                                                @endif


                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-10 custom-col-10 col-lg-12">
                    <div class="slider__inner slider-active">
                        @foreach ($data['sliders'] as $item)
                            <a href="{{ route('category.slug', $item->slug) }}">
                                <div class="single-slider w-img">
                                    <img src="{{ asset('uploads/images/product/category/slider/' . $item->slider_image) }}"
                                        alt="{{ $item->name }}">
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- slider area end -->

    <!-- features area start -->
    <section class="features__area grey-bg-2 pt-30 pb-20 pl-10 pr-10 shipping-container">
        <div class="container">
            <div class="row row-cols-xxl-5 row-cols-xl-5 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 gx-0">
                <div class="col">
                    <div class="features__item d-flex white-bg">
                        <div class="features__icon mr-15">
                            <i class="fal fa-rocket-launch"></i>
                        </div>
                        <div class="features__content">
                            <h6>Free Shipping</h6>
                            <p>Shipping All Over Nepal</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="features__item d-flex white-bg">
                        <div class="features__icon mr-15">
                            <i class="fal fa-sync"></i>
                        </div>
                        <div class="features__content">
                            <h6>Products Warranty</h6>
                            <p>Genuine Products</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="features__item d-flex white-bg">
                        <div class="features__icon mr-15">
                            <i class="fal fa-user-headset"></i>
                        </div>
                        <div class="features__content">
                            <h6>Technical Support</h6>
                            <p>24/7 Online Support</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="features__item d-flex white-bg">
                        <div class="features__icon mr-15">
                            <i class="fal fa-thumbs-up"></i>
                        </div>
                        <div class="features__content">
                            <h6>Secure Payment</h6>
                            <p>All Payment Method are accepted</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="features__item features__item-last d-flex white-bg">
                        <div class="features__icon mr-15">
                            <i class="fal fa-badge-dollar"></i>
                        </div>
                        <div class="features__content">
                            <h6>Member Discount</h6>
                            <p>Attractive Discount Packages</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- features area end -->

    {{-- categories area start --}}
    <section class="deal__area pb-45 pt-25 grey-bg ">
        <div class="container">
            <div class="row">
                <div class="section__head d-md-flex justify-content-between mb-40">
                    <div class="section__title">
                        <h3>Categories</h3>
                    </div>
                </div>
                <div class="categories-carousel row">
                    @foreach ($data['categories'] as $item)
                        <div class="col-md-4 col-lg-3 col-xl-2 carousel-item-wrapper">
                            <div class="product__item white-bg mb-30">
                                <div class="product__thumb p-relative category__list">
                                    <a href="{{ route('category.slug', $item->slug ?? '') }}" class="w-img">
                                        <img loading="lazy"
                                            src="{{ asset('uploads/images/product/category/' . $item->image) }}"
                                            alt="{{ $item->name ?? 'No Image' }}">
                                    </a>
                                </div>
                                <div class="product__content text-center">
                                    <h6 class="product-name">
                                        <a class="product-item-link"
                                            href="{{ route('category.slug', $item->slug ?? '') }}">{{ $item->name }}</a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
    </section>
    {{-- categories area end --}}

    <!-- product Area Start-->
    <section class="deal__area pb-45 pt-25 grey-bg ">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section__head d-md-flex justify-content-between align-items-center mb-40">
                        <div class="section__title">
                            <h3>Only For You</h3>
                        </div>
                    </div>

                    <div class="row" id="productContainer">
                        @include('site.page.partials.product-box', ['products' => $data['products']])
                    </div>
                    <div>
                        <div id="load-more-spinner" class="text-center mt-3" style="display: none;">
                            <p>Loading...</p>
                        </div>
                        <div class="text-center mt-3 d-none d-md-block">
                            <button id="loadMoreBtn" class="t-y-btn t-y-btn-2">Load More</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    {{-- product Area End --}}
@endsection
@push('scripts')

    {{-- Brand --}}
    <script>
        document.querySelectorAll('.brand-link').forEach(function(link) {
            link.addEventListener('click', function() {
                const inputId = this.getAttribute('data-target');
                const radioInput = document.getElementById(inputId);

                if (radioInput) {
                    radioInput.checked = true;
                    const brandSlug = radioInput.value;
                    if (brandSlug) {
                        const url = `/search/${encodeURIComponent(brandSlug)}`;
                        window.location.href = url;
                    }
                }
            });
        });
    </script>

    {{-- Add to Wishlist --}}
    <script>
        $(document).ready(function() {
            // Add to Wishlist without confirmation
            $('.cart-wishlist').click(function(e) {
                e.preventDefault(); // Prevent default action if it's a link

                var productId = $(this).data('id'); // Get the item ID
                var productID = $(this).attr('product-id'); // Get the product ID

                var url = '{{ route('wishlist.add', ':id') }}'.replace(':id', productId);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token
                        product_id: productID, // Send product ID
                    },
                    success: function(response) {
                        alert(response.message); // Show success message
                        location.reload(); // Reload to reflect changes
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText); // Show error
                    }
                });
            });
        });
    </script>

    {{-- Load More --}}
    <script>
        let page = 2;
        let loading = false;

        // Load More Products
        const loadMore = () => {
            if (loading) return;
            loading = true;
            $('#load-more-spinner').show();

            $.ajax({
                url: "{{ route('products.load.more') }}?page=" + page,
                type: 'GET',
                success: function(data) {
                    if (data.trim() === '') {
                        $(window).off('scroll');
                        $('#loadMoreBtn').hide();
                        $('#load-more-spinner').hide();
                        return;
                    }

                    $('#productContainer').append(data);
                    page++;
                    loading = false;
                    $('#load-more-spinner').hide();
                },
                error: function() {
                    loading = false;
                    $('#load-more-spinner').hide();
                }
            });
        };

        // Auto Load for Mobile (width < 768px)
        if (window.innerWidth < 768) {
            $(window).on('scroll', function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                    loadMore();
                }
            });
        }

        // Load More Button for Desktop
        $('#loadMoreBtn').on('click', function() {
            loadMore();
        });
    </script>
@endpush
