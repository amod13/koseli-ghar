@extends('site.main.app')
@section('content')
    @include('alert.sitemessage')
    @include('site.page.checkout.breadcrumb')

    <!-- checkout-area start -->
    <section class="checkout-area pb-70">
        <div class="container">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="checkbox-form">
                            <h3>Billing Details</h3>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="checkout-form-list">
                                        <label>First Name <span class="required">*</span></label>
                                        <input type="text" placeholder="" name="first_name" value="{{ $data['userDetail']->first_name ?? '' }}" />
                                        <span class="text-danger">
                                            @error('first_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="checkout-form-list">
                                        <label>Middle Name</label>
                                        <input type="text" placeholder="" name="middle_name" value="{{ $data['userDetail']->middle_name ?? '' }}" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="checkout-form-list">
                                        <label>Last Name <span class="required">*</span></label>
                                        <input type="text" placeholder="" name="last_name" value="{{ $data['userDetail']->last_name ?? '' }}" />
                                        <span class="text-danger">
                                            @error('last_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Email Address <span class="required">*</span></label>
                                        <input type="email" placeholder="" name="email" value="{{ auth()->check() ? auth()->user()->email : ($data['userDetail']->email ?? '') }}" />
                                        <span class="text-danger">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Phone <span class="required">*</span></label>
                                        <input type="text" placeholder="" name="phone" value="{{ $data['userDetail']->phone ?? Auth::user()->phone_number ?? '' }}"/>
                                        <span class="text-danger">
                                            @error('phone')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Company Name <span class="text-primary">(optional)</span></label>
                                        <input type="text" placeholder="" name="company_name" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Address <span class="required">*</span></label>
                                        <input type="text" placeholder="Street address" name="address" value="{{ $data['userDetail']->address ?? '' }}"/>
                                        <span class="text-danger">
                                            @error('address')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label for="apartment">Apartment, suite, unit etc. <span class="text-primary">(optional)</span></label>
                                        <input type="text" placeholder="Apartment, suite, unit etc." name="city" />
                                    </div>
                                </div>
                                <input type="hidden" name="total_price" value="{{ $data['totalPrice'] }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? '' }}">
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="your-order mb-30 ">
                            <h3>Your order</h3>
                            <div class="your-order-table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th class="product-name">Product</th>
                                            <th class="product-total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['cartItems'] as $item)
                                        <tr class="cart_item">
                                            <td>
                                                <img src="{{ asset('uploads/images/product/thumbnailImage/' . $item->image) }}" alt="" style="height: 80px;width:80px;">
                                            </td>
                                            <td class="product-name">
                                                {{ $item->product_name }} <strong class="product-quantity"> × {{ $item->quantity }}</strong>
                                            </td>
                                            <td class="product-total">
                                                <span class="amount">₨ {{ number_format($item->product_price * $item->quantity, 2) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="cart-subtotal">
                                            <th>Cart Subtotal</th>
                                            <td><span class="amount">₨ {{ number_format($data['totalPrice'], 2) }}</span></td>
                                        </tr>
                                        <tr class="shipping">
                                            <th>Shipping</th>
                                            <td>
                                                <ul>
                                                    <li>
                                                        <label>Free Shipping</label>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>Order Total</th>
                                            <td><strong><span class="amount">₨ {{ number_format($data['totalPrice'], 2) }}</span></strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="payment-method">
                                <div class="payment-method">
                                    <label class="form-label mb-2">Choose Payment Method</label>

                                    <div class="btn-group d-flex" role="group" aria-label="Payment Method">
                                        @auth
                                            <input type="radio" class="btn-check" name="payment_method" id="cod" value="cod" autocomplete="off" required>
                                            <label class="btn btn-outline-primary w-100 me-2" for="cod">Cash On Delivery</label>
                                        @endauth

                                        <input type="radio" class="btn-check" name="payment_method" id="esewa" value="esewa" autocomplete="off">
                                        <label class="btn btn-outline-success w-100" for="esewa">eSewa</label>
                                        <span class="text-danger">
                                            @error('payment_method')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="order-button-payment mt-20">
                                    <button type="submit" class="t-y-btn">Place order</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- checkout-area end -->


@endsection
