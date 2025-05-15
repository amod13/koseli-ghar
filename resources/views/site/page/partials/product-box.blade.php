@foreach ($data['products'] as $product)
    <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="product__item white-bg mb-30">
            <div class="product__thumb p-relative">
                <a href="{{ route('single.product.view', $product->slug) }}" class="w-img">
                    <img src="{{ asset('uploads/images/product/thumbnailImage/' . $product->image) }}" alt="product" class="product__image">

                    <div class="product__action p-absolute">
                        <ul>
                            @if ($data['setting']->is_display_wishlist == 1)
                            <li>
                                <a href="javascript:void(0)" title="Add to Wishlist" class="cart-wishlist"
                                    data-id = "{{ $product->id }}" product-id = "{{ $product->id }}">
                                    <i class="fal fa-heart"></i>
                                </a>
                            </li>
                            @endif
                            @if ($data['setting']->is_display_cart == 1)
                            <li>
                                <a href="">
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
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
                    <a class="product-item-link" href="{{ route('single.product.view', $product->slug) }}">
                        {{ \Illuminate\Support\Str::words($product->name, $data['setting']->limit_title, '...') }}
                    </a>
                </h6>

                <div class="rating">
                    <ul>
                        @for ($i = 0; $i < 5; $i++)
                            <li><a href="#"><i class="far fa-star"></i></a></li>
                        @endfor
                    </ul>
                </div>
                @php
                    $discountPercentage = 0;
                    if ($product->original_price > 0 && $product->discounted_price > 0) {
                        $discountPercentage = round(
                            (($product->original_price - $product->discounted_price) / $product->original_price) * 100,
                        );
                    }
                @endphp

                @if ($discountPercentage > 0)
                    <span class="price">Rs.{{ number_format($product->discounted_price, 2) }}</span>
                    <span class="price-old mb-5">
                        <del>₨ {{ number_format($product->original_price, 2) }}</del>
                    </span>
                    <span class="discount text-danger">-{{ $discountPercentage }}%
                        OFF</span>
                @else
                    <span class="price">Rs.{{ number_format($product->original_price, 2) }}</span>
                @endif

            </div>
        </div>
    </div>
@endforeach
