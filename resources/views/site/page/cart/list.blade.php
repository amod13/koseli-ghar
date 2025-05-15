@extends('site.main.app')
@section('content')
    @include('alert.cartmessage')
    @include('site.page.cart.breadcrumb')

    @if (count($data['cartItems']) > 0)
        <!-- Cart Area Start -->
        <section class="cart-area pt-10 pb-100">
            <div class="container">
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
                                                        <button class="btn btn-outline-secondary qty-btn minus"
                                                            type="button">-</button>
                                                        <input type="number" name="quantities[{{ $item->id }}]"
                                                            value="{{ $item->quantity }}" min="1"
                                                            class="form-control text-center cart-quantity" />
                                                        <button class="btn btn-outline-secondary qty-btn plus"
                                                            type="button">+</button>
                                                    </div>
                                                </td>

                                                <td class="product-subtotal">
                                                    <span class="amount">₨
                                                        {{ number_format($item->product_price * $item->quantity, 2) }}</span>
                                                </td>
                                                <td class="product-remove d-flex">
                                                    <button type="button" title="Remove from Cart"
                                                        class="cart-remove btn btn-danger" data-id="{{ $item->id }}">
                                                        <i class="fa fa-remove text-white"></i>
                                                    </button>
                                                    @auth
                                                        <button type="button" title="Add to Wishlist"
                                                            class="cart-wishlist btn btn-dark ms-2"
                                                            data-id = "{{ $item->id }}"
                                                            product-id = "{{ $item->product_id }}">
                                                            <i class="fa fa-heart text-white"></i>
                                                        </button>
                                                    @endauth
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
                        src="{{ asset('site/assets/img/cart.gif') }}" width="130" height="130"
                        class="img-fluid mb-4 mr-3">
                    <h3><strong>Your Cart is Empty</strong></h3>
                    <h4>Add something to make me happy 🙂</h4><a href="{{ url('/') }}" class="t-y-btn m-3"
                        data-abc="true">Continue shopping</a>
                </div>
            </div>
        </div>
    @endif

    <!-- Remove From Cart Modal -->
    <div id="cartRemoveModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-md-5">
                    <div class="text-center modal-content-body">
                        <div class="text-danger">
                            <i class="bi bi-exclamation-triangle display-4"></i>
                        </div>
                        <div class="mt-4 fs-15">
                            <h4 class="mb-1">Are you sure?</h4>
                            <p class="text-muted mx-4 mb-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn w-sm btn-danger" id="confirmDelete">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wishlist Confirm Modal -->
    <div id="wishlistConfirmModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-md-5">
                    <div class="text-center modal-content-body">
                        <div class="text-warning">
                            <i class="bi bi-heart-fill display-4"></i>
                        </div>
                        <div class="mt-4 fs-15">
                            <h4 class="mb-1">Move to Wishlist?</h4>
                            <p class="text-muted mx-4 mb-0">You can still access it from your wishlist.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn w-sm btn-warning" id="confirmWishlistMove">Yes, Move</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@push('scripts')
    {{-- cart and wishlist confiormation message --}}
    <script>
        let itemIdToDelete = null;
        let wishlistProductId = null;
        let wishlistProductID = null;

        // Remove from cart modal trigger
        $('.cart-remove').click(function() {
            itemIdToDelete = $(this).data('id');
            $('#cartRemoveModal').modal('show');
        });

        // Confirm remove from cart
        $('#confirmDelete').click(function() {
            if (itemIdToDelete) {
                let url = '{{ route('cart.remove', ':id') }}'.replace(':id', itemIdToDelete);
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#cartRemoveModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        $('#cartRemoveModal').modal('hide');
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        });

        // Add to wishlist modal trigger
        $('.cart-wishlist').click(function() {
            wishlistProductId = $(this).data('id');
            wishlistProductID = $(this).attr('product-id');
            $('#wishlistConfirmModal').modal('show');
        });

        // Confirm move to wishlist
        $('#confirmWishlistMove').click(function() {
            if (wishlistProductId && wishlistProductID) {
                let url = '{{ route('wishlist.add', ':id') }}'.replace(':id', wishlistProductId);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: wishlistProductID
                    },
                    success: function(response) {
                        $('#wishlistConfirmModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        $('#wishlistConfirmModal').modal('hide');
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        });
    </script>

    {{-- cart quantity --}}
    <script>
        $(document).ready(function() {
            // Submit the form when quantity input changes
            $('.cart-quantity').on('change', function() {
                if (parseInt(this.value) >= 1) {
                    $(this).closest('form').submit();
                }
            });

            // Handle click on plus/minus buttons
            $('.qty-btn').on('click', function() {
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
