@extends('site.main.app')
@section('content')
    @include('alert.sitemessage')
    @include('site.page.shop.breadcrumb')

    <!-- product area start -->
    <section class="product__area box-plr-75 pb-70">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xxl-2 col-xl-3 col-lg-4 sidbar__of_shop" id="filterContainer">
                    <form action="{{ route('site.brand.search') }}" method="GET" id="filterForm">

                        {{-- Price Range --}}
                        <div class="product__widget-item mb-3">
                            <div class="accordion" id="productWidgetAccordion1">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingPrice">
                                        <button class="accordion-button product__widget-title" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="true"
                                            aria-controls="collapsePrice">
                                            Price
                                        </button>
                                    </h2>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Price Range (NPR)</label>
                                        <div class="range-container">
                                            <input type="range" id="minRange" name="min_price" min="0"
                                                max="100000" value="{{ request('min_price', 100) }}">
                                            <input type="range" id="maxRange" name="max_price" min="0"
                                                max="100000" value="{{ request('max_price', 100000) }}">
                                        </div>

                                        <div class="d-flex justify-content-between mt-2">
                                            <span>NPR <span id="minPriceLabel">{{ request('min_price', 100) }}</span></span>
                                            <span>NPR <span
                                                    id="maxPriceLabel">{{ request('max_price', 100000) }}</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Categories --}}
                        <div class="product__widget">
                            <div class="product__widget-item mb-15">
                                <div class="accordion" id="productWidgetAccordion5">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button product__widget-title" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseCategory"
                                                aria-expanded="true" aria-controls="collapseCategory">
                                                Categories
                                            </button>
                                        </h2>
                                        <div id="collapseCategory" class="accordion-collapse collapse show"
                                            aria-labelledby="headingThree" data-bs-parent="#productWidgetAccordion5">
                                            <div class="accordion-body">
                                                <div class="product__widget-content">
                                                    <div class="pt-10">
                                                        <ul class="list-unstyled">
                                                            @foreach ($data['categories'] as $item)
                                                                <li class="form-check">
                                                                    <input class="form-check-input checkbox__input"
                                                                        type="checkbox" name="category_id[]"
                                                                        value="{{ $item->id }}"
                                                                        {{ in_array($item->id, $data['selectedCategories'] ?? []) || ($data['categoryId'] ?? null) == $item->id ? 'checked' : '' }}>

                                                                    <label class="form-check-label"
                                                                        for="size{{ $loop->index }}">
                                                                        {{ $item->name }}
                                                                    </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Brands --}}
                        <div class="product__widget">
                            <div class="product__widget-item mb-15">
                                <div class="accordion" id="productWidgetAccordion2">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button product__widget-title" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="true" aria-controls="collapseThree">
                                                Brands
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse show"
                                            aria-labelledby="headingThree" data-bs-parent="#productWidgetAccordion2">
                                            <div class="accordion-body">
                                                <div class="product__widget-content">
                                                    <div class="pt-10">
                                                        <ul class="list-unstyled">
                                                            @foreach ($data['brands'] as $item)
                                                                <li class="form-check">
                                                                    <input class="form-check-input checkbox__input"
                                                                        type="checkbox" name="brand_id[]"
                                                                        value="{{ $item->id }}"
                                                                        {{ in_array($item->id, $data['selectedBrands'] ?? []) || ($data['searchBrand'] ?? null) == $item->id ? 'checked' : '' }}>

                                                                    <label class="form-check-label"
                                                                        for="size{{ $loop->index }}">
                                                                        {{ $item->name }}
                                                                    </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="col-xxl-10 col-xl-9 col-lg-8 order-first order-lg-last">
                    <div class="product__grid-wrapper">
                        @if (!empty($data['searchKeyword']))
                        <h4 class="text-center">Search Request For: <span class="text-danger">{{ $data['searchKeyword'] }}</span></h4>
                        @endif
                        <div class="product__grid-banner w-img">
                            <img src="{{ asset('site/assets/img/banner/banner_grid.png') }}" alt="">
                        </div>
                        @if ($data['products']->count())
                            <div class="product__grid-item-wrapper pt-30">
                                <div class="product__filter mb-50">
                                    <div class="row align-items-center">

                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                                            <div class="product__filter-left d-sm-flex align-items-center">
                                                <div class="product__col">
                                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link active" id="FourCol-tab"
                                                                data-bs-toggle="tab" data-bs-target="#FourCol"
                                                                type="button" role="tab" aria-controls="FourCol"
                                                                aria-selected="true">
                                                                <i class="fal fa-border-all"></i>
                                                            </button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="list-tab" data-bs-toggle="tab"
                                                                data-bs-target="#list" type="button" role="tab"
                                                                aria-controls="list" aria-selected="false">
                                                                <i class="fal fa-list"></i>
                                                            </button>
                                                        </li>

                                                        <li class="nav-item" role="ShortCut">
                                                            <a class="item SearchFilter" data-bs-toggle="offcanvas"
                                                                href="#offcanvasSearchFilter" role="button"
                                                                aria-controls="offcanvasSearchFilter">
                                                                <div class="icon">
                                                                    <i class="fa-solid fa-filter"></i>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="product__result pl-60">
                                                    <p>
                                                        Showing
                                                        {{ $data['products']->firstItem() }}–{{ $data['products']->lastItem() }}
                                                        of {{ $data['products']->total() }} results
                                                    </p>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-12">
                                            {{-- If Needed Add Pagination rule --}}
                                            <div
                                                class="product__filter-right d-flex align-items-center justify-content-md-end">
                                                <div class="product__sorting product__show-position ml-20">
                                                    <select id="productSortSelect">
                                                        <option value="latest">Sort by latest</option>
                                                        <option value="low_high">price: low to high</option>
                                                        <option value="high_low">price: high to low</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-content" id="productGridTabContent">
                                    <div class="tab-pane fade  show active" id="FourCol" role="tabpanel"
                                        aria-labelledby="FourCol-tab">
                                        <div class="row">
                                            @foreach ($data['products'] as $product)
                                                <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-6 product__grid_list">
                                                    <div class="product__item white-bg mb-30 related__product_view">
                                                        <div class="product__thumb p-relative">
                                                            <a href="{{ route('single.product.view', $product->slug) }}"
                                                                class="w-img">
                                                                <img src="{{ asset('uploads/images/product/thumbnailImage/' . $product->image) }}"
                                                                    alt="product">

                                                                <div class="product__action p-absolute">
                                                                    <ul>
                                                                        @if ($data['setting']->is_display_wishlist == 1)
                                                                            <li>
                                                                                <a href="javascript:void(0)"
                                                                                    title="Add to Wishlist"
                                                                                    class="cart-wishlist"
                                                                                    data-id = "{{ $item->id }}"
                                                                                    product-id = "{{ $item->id }}">
                                                                                    <i class="fal fa-heart"></i>
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                        @if ($data['setting']->is_display_cart == 1)
                                                                            <li>
                                                                                <a href="">
                                                                                    <form action="{{ route('cart.add') }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="product_id"
                                                                                            value="{{ $product->id }}">
                                                                                        <input type="hidden"
                                                                                            name="quantity"
                                                                                            value="1">
                                                                                        <button type="submit"
                                                                                            title="Add to Cart"
                                                                                            style="background: none; border: none; padding: 0;">
                                                                                            <i
                                                                                                class="fas fa-shopping-cart"></i>
                                                                                        </button>
                                                                                    </form>
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>

                                                            </a>
                                                        </div>
                                                        <div class="product__content text-center">
                                                            <h6 class="product-name">
                                                                <a class="product-item-link"
                                                                    href="{{ route('single.product.view', $product->slug) }}">
                                                                    {{ \Illuminate\Support\Str::words($product->name, $data['setting']->limit_title, '...') }}
                                                                </a>
                                                            </h6>
                                                            <div class="rating">
                                                                <ul>
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <li><a href="#"><i
                                                                                    class="far fa-star"></i></a>
                                                                        </li>
                                                                    @endfor
                                                                </ul>
                                                            </div>
                                                            @php
                                                                $discountPercentage = 0;
                                                                if (
                                                                    $product->original_price > 0 &&
                                                                    $product->discounted_price > 0
                                                                ) {
                                                                    $discountPercentage = round(
                                                                        (($product->original_price -
                                                                            $product->discounted_price) /
                                                                            $product->original_price) *
                                                                            100,
                                                                    );
                                                                }
                                                            @endphp

                                                            @if ($discountPercentage > 0)
                                                                <span
                                                                    class="price">Rs.{{ number_format($product->discounted_price, 2) }}</span>
                                                                <span class="price-old mb-5">
                                                                    <del>₨
                                                                        {{ number_format($product->original_price, 2) }}</del>
                                                                </span>
                                                                <span
                                                                    class="discount text-danger">-{{ $discountPercentage }}%
                                                                    OFF</span>
                                                            @else
                                                                <span
                                                                    class="price">Rs.{{ number_format($product->original_price, 2) }}</span>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="row">
                                                <div class="col-xxl-12 justify-content-center">
                                                    {{ $data['products']->links('pagination::bootstrap-5') }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="list" role="tabpanel"
                                        aria-labelledby="list-tab">
                                        <div class="row">
                                            <div class="col-xxl-12">
                                                @foreach ($data['products'] as $product)
                                                    <div class="product__item product__list white-bg mb-30 d-md-flex product__grid_list">
                                                        <div class="product__thumb p-relative mr-20">
                                                            <a href="{{ route('single.product.view', $product->slug) }}"
                                                                class="w-img">
                                                                <img src="{{ asset('uploads/images/product/thumbnailImage/' . $product->image) }}"
                                                                    alt="product">
                                                            </a>
                                                        </div>
                                                        <div class="product__content">
                                                            <h6 class="product-name">
                                                                <a class="product-item-link"
                                                                    href="{{ route('single.product.view', $product->slug) }}">{{ $product->name }}</a>
                                                            </h6>
                                                            <div
                                                                class="rating d-sm-flex d-lg-block d-xl-flex align-items-center">
                                                                <ul>
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <li><a href="#"><i
                                                                                    class="far fa-star"></i></a>
                                                                        </li>
                                                                    @endfor
                                                                </ul>
                                                                <div class="product-review-action ml-30">
                                                                    <span><a href="#">2 Reviews</a></span>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $discountPercentage = 0;
                                                                if (
                                                                    $product->original_price > 0 &&
                                                                    $product->discounted_price > 0
                                                                ) {
                                                                    $discountPercentage = round(
                                                                        (($product->original_price -
                                                                            $product->discounted_price) /
                                                                            $product->original_price) *
                                                                            100,
                                                                    );
                                                                }
                                                            @endphp

                                                            @if ($discountPercentage > 0)
                                                                <span
                                                                    class="price">Rs.{{ number_format($product->discounted_price, 2) }}</span>
                                                                <span class="price-old mb-5">
                                                                    <del>₨
                                                                        {{ number_format($product->original_price, 2) }}</del>
                                                                </span>
                                                                <span
                                                                    class="discount text-danger">-{{ $discountPercentage }}%
                                                                    OFF</span>
                                                            @else
                                                                <span
                                                                    class="price">Rs.{{ number_format($product->original_price, 2) }}</span>
                                                            @endif
                                                            <p class="product-text">
                                                                {!! \Illuminate\Support\Str::words(strip_tags($product->description), 20, '...') !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="row">
                                                    <div class="col-xxl-12 justify-content-center">
                                                        {{ $data['products']->links('pagination::bootstrap-5') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        @else
                            <div
                                class="no__product_found d-flex flex-column align-items-center justify-content-center py-5 bg-light rounded shadow-sm">
                                <i class="fas fa-box-open text-primary fs-1 mb-3"></i>
                                <h2 class="text-secondary mb-2 fw-semibold">No Product Found</h2>
                                <p class="text-muted">Try adjusting your filters or check back later.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- product area end -->


    <!-- Offcanvas Wrapper -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSearchFilter"
        aria-labelledby="offcanvasSearchFilterLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Filter Products</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="offcanvasFilterBody">
            <!-- Form will be moved here on mobile -->
        </div>
    </div>



@endsection

@push('scripts')

    {{-- Price Range Js Increase Or Decrease --}}
    <script>
        const filterForm = document.getElementById('filterForm');
        const minRange = document.getElementById('minRange');
        const maxRange = document.getElementById('maxRange');
        const brandCheckboxes = document.querySelectorAll('input[name="brand_id[]"]');
        const categorycheckboxes = document.querySelectorAll('input[name="category_id[]"]');

        const minLabel = document.getElementById('minPriceLabel');
        const maxLabel = document.getElementById('maxPriceLabel');

        function updateLabelsAndSubmit() {
            let minVal = parseInt(minRange.value);
            let maxVal = parseInt(maxRange.value);

            if (minVal > maxVal) {
                [minRange.value, maxRange.value] = [maxVal, minVal];
                minVal = parseInt(minRange.value);
                maxVal = parseInt(maxRange.value);
            }

            minLabel.textContent = minVal;
            maxLabel.textContent = maxVal;

            // Submit the form
            filterForm.submit();
        }

        minRange.addEventListener('change', updateLabelsAndSubmit);
        maxRange.addEventListener('change', updateLabelsAndSubmit);

        // Submit when any brand checkbox is toggled
        brandCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                filterForm.submit();
            });
        });
        categorycheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                filterForm.submit();
            });
        });

        // Initial label setup (optional)
        minLabel.textContent = minRange.value;
        maxLabel.textContent = maxRange.value;
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

    {{-- Offcanvas Js --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('filterForm');
            const originalContainer = document.getElementById('filterContainer');
            const mobileContainer = document.getElementById('offcanvasFilterBody');

            function moveFormResponsive() {
                if (window.innerWidth <= 768) {
                    if (!mobileContainer.contains(form)) {
                        mobileContainer.appendChild(form);
                    }
                } else {
                    if (!originalContainer.contains(form)) {
                        originalContainer.appendChild(form);
                    }
                }
            }

            moveFormResponsive();
            window.addEventListener('resize', moveFormResponsive);
        });
    </script>

    {{-- Product Sort --}}
    <script>
        $(document).ready(function() {
            $('#productSortSelect').on('change', function() {
                debugger;
                var sortType = $(this).val();
                var $productContainer = $('#FourCol .row');
                var $products = $productContainer.find('.product__grid_list');

                if (sortType === 'low_high') {
                    $products.sort(function(a, b) {
                        var priceA = parseFloat($(a).find('.price').first().text().replace(
                            /[^\d.]/g, ''));
                        var priceB = parseFloat($(b).find('.price').first().text().replace(
                            /[^\d.]/g, ''));
                        return priceA - priceB;
                    });
                } else if (sortType === 'high_low') {
                    $products.sort(function(a, b) {
                        var priceA = parseFloat($(a).find('.price').first().text().replace(
                            /[^\d.]/g, ''));
                        var priceB = parseFloat($(b).find('.price').first().text().replace(
                            /[^\d.]/g, ''));
                        return priceB - priceA;
                    });
                } else if (sortType === 'latest') {
                    location.reload();
                    return;
                }

                $productContainer.empty().append($products);
            });
        });
    </script>

    {{-- Price Range Backgroun Color Set In a Middle --}}
    <script>
        $(document).ready(function() {
            const $minRange = $('#minRange');
            const $maxRange = $('#maxRange');

            function updateRangeBackground() {
                const min = parseInt($minRange.attr('min'));
                const max = parseInt($minRange.attr('max'));

                const minVal = parseInt($minRange.val());
                const maxVal = parseInt($maxRange.val());

                const minPercent = ((minVal - min) / (max - min)) * 100;
                const maxPercent = ((maxVal - min) / (max - min)) * 100;

                const background = `linear-gradient(to right,
                #ddd 0%,
                #ddd ${minPercent}%,
                #007bff ${minPercent}%,
                #007bff ${maxPercent}%,
                #ddd ${maxPercent}%,
                #ddd 100%)`;

                $minRange.css('background', background);
                $maxRange.css('background', background);
            }

            $minRange.on('input', updateRangeBackground);
            $maxRange.on('input', updateRangeBackground);

            // Initialize on page load
            updateRangeBackground();
        });
    </script>

@endpush
