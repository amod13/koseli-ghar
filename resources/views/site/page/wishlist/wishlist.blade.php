@extends('site.main.app')
@section('content')
@include('alert.sitemessage')
@include('site.page.wishlist.breadcrumb')


    <!-- Wishlist Area Start -->
    @if (count($data['wishlistItems']) > 0)
    <section class="cart-area pb-100">
        <div class="container">
            <div class="row">
                <!-- Loop through wishlist items -->
                @foreach ($data['wishlistItems'] as $item)
                <div class="col-lg-4 col-md-6 mb-4 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <!-- Product Image -->
                                <div class="product-thumbnail">
                                    <a href="{{ route('single.product.view', $item->slug) }}">
                                        <img src="{{ asset('uploads/images/product/thumbnailImage/' . $item->image) }}" alt="Product Image" class="img-fluid wishlist-img" style="max-width: 120px; height: auto;">
                                    </a>
                                </div>

                                <!-- Product Details -->
                                <div class="ml-3">
                                    <h5 class="card-title">
                                        <a href="{{ route('single.product.view', $item->slug) }}">{{ $item->product_name }}</a>
                                    </h5>
                                    <p class="card-text">
                                        <span class="text-muted">Unit Price: </span><span class="amount">Rs. {{ $item->original_price }}</span>
                                    </p>
                                    <p class="card-text">
                                        <span class="text-muted">Discount Price: </span><span class="amount text-success">Rs. {{ $item->discounted_price }}</span>
                                    </p>
                                    <p class="card-text">
                                        <span class="text-muted">Discount Percentage: </span><span class="amount text-info">{{ $item->category_discount }}%</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <!-- Add To Cart Button -->
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <button class="t-y-btn btn-sm" type="submit">  <i class="fa fa-shopping-cart"></i></button>
                            </form>

                            <!-- Total Price -->
                            <span class="font-weight-bold"><span class="text-dark">Total</span>-Rs. {{ $item->discounted_price }}</span>

                            <!-- Remove Button -->
                            <form action="{{ route('wishlist.delete', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="text-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @else
    <div class="entry-content container">
            <div class="card-body cart">
                <div class="col-sm-12 empty-cart-cls text-center"><img decoding="async"
                        src="{{ asset('site/assets/img/cart.png') }}" width="130" height="130"
                        class="img-fluid mb-4 mr-3">
                    <h3><strong>Your Wishlist is Empty</strong></h3>
                    <h4>Add something to make me happy 🙂</h4><a href="{{ url('/') }}" class="t-y-btn m-3"
                        data-abc="true">Continue shopping</a>
                </div>
            </div>
        </div>
    @endif
    <!-- Wishlist Area End -->

@endsection
