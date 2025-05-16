<!-- Created based on Youtube [CodingLab](https://www.youtube.com/@CodingLabYT)-->
<!-- Need an individual APIkey from OpenAI to make the bot work. it's free but with limitations-->



<!-- Code :) -->
@include('site.page.chat.index')



</main>

<!-- footer area start -->
<footer class="footer__area bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row">
            <!-- Left: Contact Information -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="footer__contact-info">
                    <h5 class="fw-bold text-uppercase mb-3">Contact Information</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fa-solid fa-location-dot me-2"></i>
                            <strong>Address:</strong>
                            <span>{{ $data['setting']->address ?? '' }}</span>
                        </li>
                        <li class="mb-2">
                            <i class="fa-solid fa-phone me-2"></i>
                            <strong>Phone:</strong>
                            <span>{{ $data['setting']->phone ?? '' }}</span>
                        </li>
                        <li class="mb-2">
                            <i class="fa-solid fa-envelope me-2"></i>
                            <strong>Email:</strong>
                            <a href="mailto:{{ $data['setting']->email ?? '' }}" class="text-decoration-none"
                                style="color: #fff;">
                                {{ $data['setting']->email }}
                            </a>
                        </li>
                    </ul>

                </div>
            </div>

            <!-- Right: Map  -->
            <div class="col-lg-4">
                <h5 class="fw-bold text-uppercase mb-3">Find Us</h5>
                <!-- Embed Google Map -->
                <div class="map-container mb-4">
                    <iframe src="{{ $data['setting']->google_map ?? '' }}" width="100%" height="200"
                        style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <!-- Social Media Icons -->
            <div class="col-lg-4 text-lg-end">
                <h5 class="fw-bold text-uppercase mb-3">Connect With Us:</h5>
                <!-- Social Media Icons -->
                <div class="social-icons">
                    @if ($data['setting']->facebook ?? '')
                        <a href="{{ $data['setting']->facebook ?? '' }}" class="text-white me-3"
                            style="font-size: 24px;" target="__blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if ($data['setting']->twitter ?? '')
                        <a href="{{ $data['setting']->twitter ?? '' }}" class="text-white me-3" style="font-size: 24px;"
                            target="__blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    @if ($data['setting']->instagram ?? '')
                        <a href="{{ $data['setting']->instagram ?? '' }}" class="text-white me-3"
                            style="font-size: 24px;" target="__blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if ($data['setting']->youtube ?? '')
                        <a href="{{ $data['setting']->youtube ?? '' }}" class="text-white" style="font-size: 24px;"
                            target="__blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                    <br>
                    <br>
                    <!-- Track Order Link -->
                    <a href="{{ route('user.track.order') }}"
                        class="btn btn-outline-light btn-sm d-inline-flex align-items-center track-order-link">
                        <i class="fas fa-shipping-fast me-2"></i> Track Order
                    </a>
                </div>
            </div>


        </div>
    </div>

    <!-- Footer Bottom Section (Copyright and Privacy) -->
    <div class="footer__bottom bg-black text-white py-3 mt-4">
        <div class="container text-center">
            <p class="mb-0">
                &copy; {{ now()->year }} <strong>{{ $data['setting']->site_name ?? '' }}</strong>. All Rights
                Reserved. |
                <a href="#" class="text-decoration-none text-white">Privacy Policy</a> |
                <a href="#" class="text-decoration-none text-white">Terms & Conditions</a>
            </p>
        </div>
    </div>
</footer>

<!-- Include Font Awesome for social media icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>


<!-- footer area end -->

<!-- Mobile site Fotter Scrollable icons start -->
<nav class="h2-tabbar" id="lzd-h2-tabbar">

    <a class="item selected home" href="{{ url('/') }}">
        <div class="icon">
            <i class="fa-solid fa-house"></i>
        </div>
        <span class="text">Home</span>

    </a>

    <a href="{{ route('get.categories') }}" class="item categories">
        <div class="icon">
            <i class="fa-solid fa-list"></i>
        </div>
        <span class="text">Categories</span>
    </a>


    <a class="item cart position-relative" href="{{ route('site.cart.list') }}">
        <div class="icon">
            <i class="fa-solid fa-cart-shopping fa-lg"></i>
            <span class="position-absolute top-0 translate-middle badge rounded-pill bg-danger">
                {{ $data['cartItems']->count() }}
                <span class="visually-hidden">cart items</span>
            </span>
        </div>
        <span class="text">Cart</span>
    </a>


    @auth
        <a class="item account" href="{{ route('site.user.profile') }}">
            <div class="icon">
                <i class="fa-solid fa-user"></i>
            </div>
            <span class="text">Account</span>
        </a>
    @endauth
    <a class="item account" href="{{ route('user.login') }}">
        <div class="icon">
            <i class="fa-solid fa-user"></i>
        </div>
        <span class="text">Account</span>
    </a>



    <style>
        .item.cart {
            text-decoration: none;
            color: inherit;
        }

        .item.cart .icon {
            display: inline-block;
            margin-right: 5px;
        }

        .item.cart .text {
            font-size: 16px;
        }

        .item.cart .cart-num {
            background-color: #fcb700;
            color: white;
            border-radius: 50%;
            padding: 0px 4px;
            margin-left: 35px;
            margin-top: -28px;
        }
    </style>


    <!-- DELETE CONFIRMATION MODAL -->
    <div id="deleteModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true" role="dialog">
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


</nav>
<!-- Mobile site Fotter Scrollable icons End -->

<!-- JS here -->
{{-- <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> --}}
<script src="{{ asset('site/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('site/assets/js/vendor/waypoints.min.js') }}"></script>
<script src="{{ asset('site/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('site/assets/js/meanmenu.js') }}"></script>
<script src="{{ asset('site/assets/js/slick.min.js') }}"></script>
<script src="{{ asset('site/assets/js/backToTop.js') }}"></script>
<script src="{{ asset('site/assets/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('site/assets/js/countdown.js') }}"></script>
<script src="{{ asset('site/assets/js/nice-select.min.js') }}"></script>
<script src="{{ asset('site/assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('site/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('site/assets/js/jquery-ui-slider-range.js') }}"></script>
<script src="{{ asset('site/assets/js/ajax-form.js') }}"></script>
<script src="{{ asset('site/assets/js/wow.min.js') }}"></script>
<script src="{{ asset('site/assets/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('site/assets/js/main.js') }}"></script>
<script src="{{ asset('site/assets/js/custom.js') }}"></script>
</body>

</html>
