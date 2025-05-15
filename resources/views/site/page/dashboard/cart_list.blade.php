@extends('site.main.app')
@section('content')
    @include('alert.sitemessage')


    @if (count($data['cartItems']) > 0)
        <!-- Cart Area Start -->
        <section class="cart-area pt-10 pb-100">
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h1 class="h3 m-0">My Cart</h1>
                    <a href="{{ route('site.user.profile', $data['userId']) }}" class="t-y-btn">
                        <i class="bi bi-arrow-left me-1"></i> Back to Profile
                    </a>
                </div>
                <br>
                <br>

                <div class="row">
                    <div class="col-12 col-md-8">

                        <form action="{{ route('cart.update') }}" method="POST" class="cart-form">
                            @csrf
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">Images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="product-price">Unit Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-remove">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['cartItems'] as $item)
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <a href="{{ route('single.product.view', $item->slug) }}">
                                                        <img src="{{ asset('uploads/images/product/thumbnailImage/' . $item->image) }}"
                                                            alt="">
                                                    </a>
                                                </td>
                                                <td class="product-name">
                                                    <a
                                                        href="{{ route('single.product.view', $item->slug) }}">{{ $item->product_name }}</a>
                                                </td>
                                                <td class="product-price">
                                                    <span class="amount">₨
                                                        {{ number_format($item->product_price, 2) }}</span>
                                                </td>

                                                {{-- <td class="product-quantity">
                                                    <div class="cart-plus-minus">
                                                        <input type="number" name="quantities[{{ $item->id }}]"
                                                            value="{{ $item->quantity }}" min="1" class="cart-quantity"/>
                                                    </div>
                                                </td> --}}

                                                <td class="product-quantity">
                                                    <div class="input-group" style="max-width: 140px;">
                                                        <button class="btn btn-outline-secondary qty-btn minus" type="button">-</button>
                                                        <input type="number" name="quantities[{{ $item->id }}]"
                                                               value="{{ $item->quantity }}" min="1"
                                                               class="form-control text-center cart-quantity" />
                                                        <button class="btn btn-outline-secondary qty-btn plus" type="button">+</button>
                                                    </div>
                                                </td>



                                                <td class="product-subtotal">
                                                    <span class="amount">₨
                                                        {{ number_format($item->product_price * $item->quantity, 2) }}</span>
                                                </td>
                                                <td class="product-remove d-flex">

                                                    <button type="button" title="Remove from Cart" class="cart-remove btn btn-danger"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fa fa-remove text-white"></i>
                                                    </button>

                                                    <button type="button" title="Add to Wishlist" class="cart-wishlist btn btn-dark ms-2"
                                                        data-id = "{{ $item->id }}"
                                                        product-id = "{{ $item->product_id }}">
                                                        <i class="fa fa-heart text-white"></i>
                                                    </button>

                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="row">
                                <div class="col-12">
                                    <div class="coupon-all">
                                        <div class="coupon2">
                                            <button class="t-y-btn t-y-btn-border" name="update_cart" type="submit">Update
                                                Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </form>

                    </div>

                    <div class="col-12 col-md-4">
                        <div class="cart-page-total">
                            <h2>Cart Totals</h2>
                            <ul class="mb-20">
                                <li>Subtotal <span>₨ {{ number_format($data['totalPrice'], 2) }}</span></li>
                                <li>Total <span>₨ {{ number_format($data['totalPrice'], 2) }}</span></li>
                            </ul>
                            <a class="t-y-btn" href="{{ route('site.checkout') }}">Proceed to Checkout</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- Cart Area End -->
    @else
        <div class="entry-content">
            <div class="card-body cart">
                <div class="col-sm-12 empty-cart-cls text-center"><img decoding="async"
                        src="{{ asset('site/assets/img/cart.png') }}" width="130" height="130" class="img-fluid mb-4 mr-3">
                    <h3><strong>Your Cart is Empty</strong></h3>
                    <h4>Add something to make me happy 🙂</h4><a href="{{ url('/') }}"
                        class="t-y-btn m-3" data-abc="true">Continue shopping</a>
                </div>
            </div>
        </div>
    @endif


@endsection
@push('scripts')

    <script>
        $(document).ready(function() {
            // Remove from cart
            $('.cart-remove').click(function() {
                var id = $(this).data('id');

                // Display a confirmation prompt before proceeding
                var confirmRemove = confirm("Are you sure you want to remove this item from your cart?");

                if (confirmRemove) {
                    var url = '{{ route('cart.remove', ':id') }}'.replace(':id', id);
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}', // Add CSRF token
                        },
                        success: function(response) {
                            alert(response.message); // Display success message from response
                            location.reload(); // Reload the page to reflect changes
                        },
                        error: function(xhr, status, error) {
                            alert('Error: ' + xhr
                            .responseText); // Display error message from response
                        }
                    });
                } else {
                    // User chose not to remove the item, do nothing
                }
            });

            // Add to Wishlist
            $('.cart-wishlist').click(function() {
                var productId = $(this).data('id'); // Get the item ID
                var productID = $(this).attr('product-id'); // Get the product ID

                // Display confirmation before adding to wishlist
                var confirmAdd = confirm("Are you sure you want to Move this item to your wishlist?");

                if (confirmAdd) {
                    var url = '{{ route('wishlist.add', ':id') }}'.replace(':id', productId);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Add CSRF token
                            product_id: productID, // Send product ID
                        },
                        success: function(response) {
                            alert(response.message); // Display success message from response
                            location.reload(); // Reload the page to reflect changes
                        },
                        error: function(xhr, status, error) {
                            alert('Error: ' + xhr
                            .responseText); // Display error message from response
                        }
                    });
                } else {
                    // If the user cancels, do nothing
                    // alert('Item was not added to your wishlist.');
                }
            });

        });
    </script>




    {{-- <script>
        $(document).ready(function() {
            let previousValue = {};

            // Store the initial value
            $('.cart-quantity').on('focus', function () {
                previousValue[this.name] = this.value;
            });

            // Detect change using arrows (step up/down)
            $('.cart-quantity').on('input', function (e) {
                let currentValue = this.value;
                let name = this.name;

                if (previousValue[name] !== currentValue) {
                    $('button[name="update_cart"]').click();
                }

                previousValue[name] = currentValue;
            });
        });
    </script> --}}


    <script>
        $(document).ready(function () {
            // Submit the form when quantity input changes
            $('.cart-quantity').on('change', function () {
                if (parseInt(this.value) >= 1) {
                    $(this).closest('form').submit();
                }
            });

            // Handle click on plus/minus buttons
            $('.qty-btn').on('click', function () {
                const input = $(this).siblings('.cart-quantity');
                let currentVal = parseInt(input.val());
                const min = parseInt(input.attr('min')) || 1;

                if ($(this).hasClass('plus')) {
                    input.val(currentVal + 1);
                } else if ($(this).hasClass('minus')) {
                    if (currentVal > min) {
                        input.val(currentVal - 1);
                    }
                }

                input.trigger('change'); // Trigger auto-submit
            });
        });
    </script>


@endpush

