@extends('site.main.app')
@section('content')
    @include('alert.sitemessageone')
    @include('site.page.product.breadcrumb')

    <style>
        /* Highlight the stars with yellow background according to the rating */
        .star-item i.star-rated {
            color: var(--secondary-color);
            border-radius: 50%;
            padding: 6px;
        }
    </style>

    <!-- Single product area start -->
    <section class="product__area box-plr-75 pb-70">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    {{-- Single product view --}}
                    <div class="row single-product__view">

                        <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <div class="product__details-nav d-sm-flex align-items-start">
                                <ul class="nav nav-tabs flex-sm-column justify-content-between" id="productThumbTab"
                                    role="tablist">
                                    @php
                                        $galleryImages = $data['product']->product_files;
                                        $hasThumbnail = isset($data['product']->image);
                                    @endphp

                                    <!-- Display Thumbnail image first if exists -->
                                    @if ($hasThumbnail)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="thumb-thumbnail-tab" data-bs-toggle="tab"
                                                data-bs-target="#thumb-thumbnail" type="button" role="tab"
                                                aria-controls="thumb-thumbnail" aria-selected="true">
                                                <img src="{{ asset('uploads/images/product/thumbnailImage/' . $data['product']->image) }}"
                                                    alt="Thumbnail Image">
                                            </button>
                                        </li>
                                    @endif

                                    <!-- Display Gallery Images -->
                                    @forelse ($galleryImages as $index => $file)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link @if ($index == 0 && !$hasThumbnail) active @endif"
                                                id="thumb{{ $index }}-tab" data-bs-toggle="tab"
                                                data-bs-target="#thumb{{ $index }}" type="button" role="tab"
                                                aria-controls="thumb{{ $index }}" aria-selected="true">
                                                <img src="{{ asset('uploads/images/product/gallery/' . $file->gallery_image) }}"
                                                    alt="Gallery Image {{ $index + 1 }}">
                                            </button>
                                        </li>
                                    @empty

                                    @endforelse
                                </ul>

                                <div class="product__details-thumb">
                                    <div class="tab-content" id="productThumbContent">
                                        <!-- Display Thumbnail image first if exists -->
                                        @if ($hasThumbnail)
                                            <div class="tab-pane fade show active" id="thumb-thumbnail" role="tabpanel"
                                                aria-labelledby="thumb-thumbnail-tab">
                                                <div class="product__details-nav-thumb zoom-effect">
                                                    <img src="{{ asset('uploads/images/product/thumbnailImage/' . $data['product']->image) }}"
                                                        alt="Thumbnail Image" class="zoom-image">
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Display Gallery Images -->
                                        @forelse ($galleryImages as $index => $file)
                                            <div class="tab-pane fade @if ($index == 0 && !$hasThumbnail) show active @endif"
                                                id="thumb{{ $index }}" role="tabpanel"
                                                aria-labelledby="thumb{{ $index }}-tab">
                                                <div class="product__details-nav-thumb zoom-effect"
                                                    id="zoom-container-{{ $index }}">
                                                    <img src="{{ asset('uploads/images/product/gallery/' . $file->gallery_image) }}"
                                                        alt="Gallery Image {{ $index + 1 }}" class="zoom-image"
                                                        id="zoom-image-{{ $index }}">
                                                </div>
                                            </div>
                                        @empty
                                            <!-- If no gallery images, fall back to default thumbnail -->

                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <div class="product__details-wrapper">
                                <div class="product__details">
                                    <h3 class="product__details-title">
                                        <a href="javascript:void(0)">{{ $data['product']->name }}</a>
                                    </h3>
                                    <div class="product__review d-sm-flex">
                                        <div class="rating rating__shop mb-15 mr-35">
                                            <ul>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <li>
                                                        <a href="#">
                                                            <i
                                                                class="fal fa-star {{ $i <= round($data['averageRating']) ? 'text-warning' : '' }}"></i>
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        </div>
                                        <div class="product__add-review mb-15">
                                            <span><a href="#">{{ $data['reviews']->count() }} Review</a></span>
                                        </div>
                                    </div>

                                    <div class="product__price">
                                        @php
                                            $discountPercentage = 0;
                                            if (
                                                $data['product']->original_price > 0 &&
                                                $data['product']->discounted_price > 0
                                            ) {
                                                $discountPercentage = round(
                                                    (($data['product']->original_price -
                                                        $data['product']->discounted_price) /
                                                        $data['product']->original_price) *
                                                        100,
                                                );
                                            }
                                        @endphp

                                        @if ($discountPercentage > 0)
                                            <!-- Discounted Price Section -->
                                            <span
                                                class="price-new">Rs.{{ number_format($data['product']->discounted_price, 2) }}</span>
                                            <br>
                                            <span class="price-old mb-3">
                                                <del>₨ {{ number_format($data['product']->original_price, 2) }}</del>
                                            </span>
                                            <span class="discount text-danger"> -{{ $discountPercentage }}% OFF</span>
                                        @else
                                            <!-- No Discount Section -->
                                            <span
                                                class="price">Rs.{{ number_format($data['product']->original_price, 2) }}</span>
                                        @endif
                                    </div>

                                    <div class="product__stock mb-3">
                                        <span>Availability :</span>
                                        <span>
                                            @if ($data['product']->stock > 0)
                                                In Stock
                                            @else
                                                <span class="text-danger"> Out of Stock</span>
                                            @endif
                                        </span>
                                    </div>

                                    <div class="product__details-quantity">
                                        <div class="pro-quan-area d-lg-flex align-items-center">
                                            <div class="product__details-quantity mb-20">
                                                <form action="{{ route('cart.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $data['product']->id }}">
                                                    <div class="pro-quan-area d-lg-flex align-items-center">
                                                        <div class="product-quantity mr-20 mb-25">
                                                            <div class="cart-plus-minus p-relative">
                                                                <input type="number" name="quantity" value="1"
                                                                    min="1" />
                                                            </div>
                                                        </div>
                                                        <div class="pro-cart-btn mb-25">
                                                            <button class="t-y-btn" type="submit">Add to cart</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product__details-action">
                                        <span>Share via:</span>
                                        <ul>
                                            <!-- Facebook Share -->
                                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&amp;title={{ $data['product']->name }}&amp;picture={{ urlencode(asset('uploads/images/product/thumbnailImage/' . $data['product']->image)) }}"
                                                    title="Share on Facebook" target="_blank"><i
                                                        class="fa-brands fa-facebook"></i></a></li>

                                            <!-- Instagram Share -->
                                            <li><a href="https://www.instagram.com/" title="Share on Instagram"
                                                    target="_blank"
                                                    onclick="alert('Instagram does not allow direct image sharing via link. Please manually upload the image and share the product link.')"><i
                                                        class="fa-brands fa-instagram"></i></a></li>

                                            <!-- WhatsApp Share -->
                                            <li><a href="https://api.whatsapp.com/send?text={{ urlencode($data['product']->name) }}%20{{ urlencode(url()->current()) }}%20{{ urlencode(asset('uploads/images/product/thumbnailImage/' . $data['product']->image)) }}"
                                                    title="Share on WhatsApp" target="_blank"><i
                                                        class="fa-brands fa-whatsapp"></i></a></li>

                                            <!-- Messenger Share -->
                                            <li><a href="https://www.facebook.com/dialog/send?link={{ urlencode(url()->current()) }}&app_id=YOUR_APP_ID"
                                                    title="Share on Messenger" target="_blank"><i
                                                        class="fa-brands fa-facebook-messenger"></i></a></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Product Details Tab and Review --}}
                    <div class="product__detail__view">
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="product__details-des-tab mb-40 mt-110">
                                    <ul class="nav nav-tabs" id="productDesTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="des-tab" data-bs-toggle="tab"
                                                data-bs-target="#des" type="button" role="tab" aria-controls="des"
                                                aria-selected="true">Details</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="review-tab" data-bs-toggle="tab"
                                                data-bs-target="#review" type="button" role="tab"
                                                aria-controls="review" aria-selected="false">Review
                                                <span
                                                    class="total__review">({{ $data['reviews']->count() }})</span></button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="tab-content" id="prodductDesTaContent">
                                    <div class="tab-pane fade show active" id="des" role="tabpanel"
                                        aria-labelledby="des-tab">
                                        <div class="product__details-des-wrapper">
                                            <div class="product__details-des mb-20">
                                                <h3>{{ $data['product']->name }}</h3>
                                                <p>
                                                    {!! $data['product']->description !!}
                                                </p>
                                            </div>
                                            <div class="product__details-des-banner w-img">
                                                <img src="assets/img/shop/product/details/product-details-banner.jpg"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="review" role="tabpanel"
                                        aria-labelledby="review-tab">
                                        <div class="product__details-review">
                                            <div class="row">
                                                <div class="col-xxl-12 col-xl-12 col-lg-12">
                                                    <div class="review-wrapper">
                                                        <h3 class="block-title">Customer Reviews</h3>
                                                        @foreach ($data['reviews'] as $item)
                                                            <div class="review-item card">
                                                                <div class="card-body">
                                                                    <h3 class="review-title">
                                                                        {{ $item->title ?? 'Awesome product' }}</h3>
                                                                    <div class="review-ratings mb-10">
                                                                        <div
                                                                            class="review-ratings-single d-flex align-items-center">
                                                                            <span>Quality</span>
                                                                            <ul>
                                                                                <!-- Loop through and display stars based on rating -->
                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                    <li class="star-item">
                                                                                        <a href="#">
                                                                                            <!-- Add 'text-warning' class to the star if it matches the rating -->
                                                                                            <i
                                                                                                class="fal fa-star {{ $i <= $item->rating ? 'star-rated' : '' }}"></i>
                                                                                        </a>
                                                                                    </li>
                                                                                @endfor
                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                    <div class="review-text">
                                                                        <p>{{ $item->review }}</p>
                                                                    </div>

                                                                    <div class="review-meta">
                                                                        <div class="review-author">
                                                                            <span>Review By </span>
                                                                            <span>{{ $item->user_name ?? 'Anonymous' }}</span>
                                                                        </div>
                                                                        <div class="review-date">
                                                                            <span class="text-danger">Posted on : </span>
                                                                            <span>{{ $item->created_at }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                @auth
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 mt-3">
                                                        <div class="review-form">
                                                            <h3>SUBMIT YOUR REVIEW</h3>
                                                            <form action="{{ route('review.store') }}" method="post">
                                                                @csrf
                                                                <div class="review-input-box mb-15 d-flex align-items-start">
                                                                    <h4 class="review-input-title">Your Rating</h4>
                                                                    <div class="review-input">
                                                                        <div class="review-ratings mb-10">
                                                                            <div
                                                                                class="review-ratings-single d-flex align-items-center">
                                                                                <span>Quality</span>
                                                                                <ul>
                                                                                    <!-- Rating stars -->
                                                                                    <li>
                                                                                        <a href="javascript:void(0)"
                                                                                            class="star" data-rating="1">
                                                                                            <i class="fas fa-star"></i>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="javascript:void(0)"
                                                                                            class="star" data-rating="2">
                                                                                            <i class="fas fa-star"></i>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="javascript:void(0)"
                                                                                            class="star" data-rating="3">
                                                                                            <i class="fas fa-star"></i>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="javascript:void(0)"
                                                                                            class="star" data-rating="4">
                                                                                            <i class="fas fa-star"></i>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="javascript:void(0)"
                                                                                            class="star" data-rating="5">
                                                                                            <i class="fas fa-star"></i>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Hidden inputs to store selected rating and other relevant information -->
                                                                        <input type="hidden" name="rating" id="rating"
                                                                            value="">
                                                                        <input type="hidden" name="product_id"
                                                                            id="product_id"
                                                                            value="{{ $data['product']->id }}">
                                                                        <input type="hidden" name="user_id" id="userId"
                                                                            value="{{ Auth::user()->id }}">
                                                                    </div>
                                                                </div>

                                                                <div class="review-input-box d-flex align-items-start">
                                                                    <h4 class="review-input-title">Review</h4>
                                                                    <div class="review-input">
                                                                        <textarea name="review" required></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="review-sub-btn">
                                                                    <button type="submit" class="t-y-btn">Submit
                                                                        Review</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @else
                                                    <!-- Alternative content for guest users -->
                                                    <p>Please <a href="{{ route('user.login') }}"><span
                                                                class="text-primary">login</span></a> to submit a review.</p>
                                                @endauth
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
    </section>
    <!-- Single product area end -->


    <!-- Related Product area start -->
    @if ($data['product']->related_products->count() > 0)
        <section class="product__area box-plr-75 pb-20">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="section__head mb-40">
                                    <div class="section__title">
                                        <h3>You may also<span> like</span></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="product__slider owl-carousel">
                                    @forelse ($data['product']->related_products as $index => $item)
                                        <div class="product__item white-bg mb-30 related__product_view">
                                            <div class="product__thumb p-relative">
                                                <a href="{{ route('single.product.view', $item->slug ?? '') }}"
                                                    class="w-img">
                                                    <img src="{{ asset('uploads/images/product/thumbnailImage/' . $item->image ?? '') }}"
                                                        alt="{{ $item->name }}">

                                                    <div class="product__action p-absolute">
                                                        <ul>
                                                            @if ($data['setting']->is_display_wishlist == 1)
                                                                <li>
                                                                    <a href="javascript:void(0)" title="Add to Wishlist"
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
                                                                            <input type="hidden" name="product_id"
                                                                                value="{{ $item->id }}">
                                                                            <input type="hidden" name="quantity"
                                                                                value="1">
                                                                            <button type="submit" title="Add to Cart"
                                                                                style="background: none; border: none; padding: 0;">
                                                                                <i class="fas fa-shopping-cart"></i>
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
                                                        href="{{ route('single.product.view', $item->slug ?? '') }}">
                                                        {{ \Illuminate\Support\Str::words($item->name, $data['setting']->limit_title, '...') }}
                                                    </a>
                                                </h6>
                                                <div class="rating">
                                                    <ul>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <li>
                                                                <a
                                                                    href="{{ route('single.product.view', $item->slug ?? '') }}">
                                                                    <i
                                                                        class="fal fa-star {{ $i <= round($data['averageRating']) ? 'text-warning' : '' }}"></i>
                                                                </a>
                                                            </li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                                @if ($discountPercentage > 0)
                                                    <span
                                                        class="price-new">Rs.{{ number_format($item->discounted_price, 2) }}</span>
                                                    <br>
                                                    <span class="price-old mb-3">
                                                        <del>₨ {{ number_format($item->original_price, 2) }}</del>
                                                    </span>
                                                    <span class="discount text-danger"> -{{ $discountPercentage }}%
                                                        OFF</span>
                                                @else
                                                    <span
                                                        class="price">Rs.{{ number_format($item->original_price, 2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Related product area end -->

@endsection

@push('scripts')
    {{-- <script>
        // Function to apply zoom effect on the active image
        function applyZoomEffect() {
            // Reset the zoom effect on all images
            const allImages = document.querySelectorAll('.zoom-image');
            allImages.forEach((img) => {
                img.style.transform = 'scale(1)';
            });

            // Get the active tab's image
            const activeImage = document.querySelector('.tab-pane.show .zoom-image');
            const zoomContainer = document.querySelector('.tab-pane.show .zoom-effect');

            // Apply zoom effect only to the active image
            if (activeImage && zoomContainer) {
                zoomContainer.addEventListener('mousemove', function(e) {
                    const containerRect = zoomContainer.getBoundingClientRect();
                    const offsetX = e.clientX - containerRect.left;
                    const offsetY = e.clientY - containerRect.top;

                    const xPercent = offsetX / zoomContainer.offsetWidth * 100;
                    const yPercent = offsetY / zoomContainer.offsetHeight * 100;

                    // Set the background position based on mouse position
                    activeImage.style.transformOrigin = `${xPercent}% ${yPercent}%`;
                    activeImage.style.transform = 'scale(2)'; // You can adjust the scale factor as needed
                });

                // Reset zoom when mouse leaves the container
                zoomContainer.addEventListener('mouseleave', function() {
                    activeImage.style.transform = 'scale(1)';
                });
            }
        }

        // Add event listener for tab change (to reapply zoom effect to active image)
        const tabs = document.querySelectorAll('.nav-link');
        tabs.forEach((tab) => {
            tab.addEventListener('click', function() {
                setTimeout(applyZoomEffect, 100); // Apply zoom effect after tab change
            });
        });

        // Initially apply zoom effect on the first active image
        applyZoomEffect();
    </script> --}}


    <script>
        // Function to apply zoom effect on the active image
        function applyZoomEffect() {
            // Reset the zoom effect on all images
            const allImages = document.querySelectorAll('.zoom-image');
            allImages.forEach((img) => {
                img.style.transform = 'scale(1)';
            });

            // Get all active tabs (to apply zoom to images within each tab)
            const allTabs = document.querySelectorAll('.tab-pane');
            allTabs.forEach((tab) => {
                const zoomContainer = tab.querySelector('.zoom-effect');
                const activeImage = tab.querySelector('.zoom-image');

                // Apply zoom effect to each active image inside every tab
                if (activeImage && zoomContainer) {
                    zoomContainer.addEventListener('mousemove', function(e) {
                        const containerRect = zoomContainer.getBoundingClientRect();
                        const offsetX = e.clientX - containerRect.left;
                        const offsetY = e.clientY - containerRect.top;

                        const xPercent = offsetX / zoomContainer.offsetWidth * 100;
                        const yPercent = offsetY / zoomContainer.offsetHeight * 100;

                        // Set the background position based on mouse position
                        activeImage.style.transformOrigin = `${xPercent}% ${yPercent}%`;
                        activeImage.style.transform = 'scale(2)'; // Adjust the scale factor as needed
                    });

                    // Reset zoom when mouse leaves the container
                    zoomContainer.addEventListener('mouseleave', function() {
                        activeImage.style.transform = 'scale(1)';
                    });
                }
            });
        }

        // Add event listener for tab change (to reapply zoom effect to active image)
        const tabs = document.querySelectorAll('.nav-link');
        tabs.forEach((tab) => {
            tab.addEventListener('click', function() {
                setTimeout(applyZoomEffect, 100); // Apply zoom effect after tab change
            });
        });

        // Initially apply zoom effect on the first active image (if any)
        document.addEventListener('DOMContentLoaded', () => {
            applyZoomEffect();
        });
    </script>



    {{-- review  --}}
    <script>
        // Rating star selection functionality
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                let rating = this.getAttribute('data-rating');
                document.getElementById('rating').value = rating;

                // Highlight the selected stars
                document.querySelectorAll('.star').forEach(s => s.classList.remove('selected'));
                for (let i = 0; i < rating; i++) {
                    document.querySelectorAll('.star')[i].classList.add('selected');
                }
            });
        });
    </script>
@endpush
